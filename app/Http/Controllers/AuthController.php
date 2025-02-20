<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        try {
            $request->validate([
                'login' => 'required',
                'password' => 'required'
            ]);
            $login = $request->login;
            $email = "";

            // Check if login is an email
            if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $email = $login;
            } else {
                // Assume login is a phone number
                $user = User::where(function ($query) use ($login) {
                    $query->where('phone', $login)
                        ->orWhereRaw("CONCAT(country_code, phone) = ?", [$login])
                        ->orWhereRaw("CONCAT('+', country_code, phone) = ?", [$login]);
                })->first();
                if ($user) {
                    $email = $user->email;
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not found.',
                    ], 400);
                }
            }
            $credentials = [
                'email' => $email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials)) {
                $user = User::where('email', $email)->first();
                if ($user->role == 'provider' && $user->status == 'inactive') {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Please wait for admin approval.',
                    ], 401);
                }

                if ($user->status == 'inactive') {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Your account is inactive.',
                    ], 401);
                }
                $token = $user->createToken('auth_token')->plainTextToken;
                $user_id = 0;
                switch ($user->role) {
                    case 'client':
                        $client = Client::where('user_id', $user->id)->first();
                        $user_id = $client->id;
                        break;
                    case 'provider':
                        $provider = Provider::where('user_id', $user->id)->first();
                        $user_id = $provider->id;
                        break;
                    case 'admin':
                        $admin = Admin::where('user_id', $user->id)->first();
                        $user_id = $admin->id;
                        break;
                }

                if (!$user->email_verified_at) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Please verify your email.',
                    ], 400);
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successfully.',
                    'user_id' => $user->id,
                    'role_id' => $user_id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "role" => $user->role,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials.',
                ], 401);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'country_code' => 'required|string',
                'phone' => 'required|string|unique:users,phone',
                'role' => 'required|in:client,provider,admin',
                'government_id' => 'required|string|exists:governments,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'sub_specialization_id' => 'nullable|exists:sub_specializations,id',
                'provider_type_id' => 'nullable|exists:provider_types,id',
                'commercial_register' => 'nullable|mimes:pdf',
                'tax_card' => 'nullable|mimes:pdf',
                'bio' => 'nullable|string',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->country_code = $request->country_code;
            $user->role = $request->role;
            if ($request->role ==  'provider') {
                $user->status = 'inactive';
            }
            if ($request->hasFile('image')) {
                $imageName = 'images/users/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/users'), $imageName);
                $user->image = $imageName;
            }
            $user->save();

            switch ($request->role) {
                case 'client':
                    $user->assignRole('client');
                    $client = new Client();
                    $client->user_id = $user->id;
                    $client->governments_id = $request->government_id;
                    $client->save();
                    break;
                case 'provider':
                    $user->assignRole('provider');
                    $provider = new Provider();
                    $provider->user_id = $user->id;
                    $provider->provider_types_id = $request->provider_types_id;
                    $provider->sub_specialization_id = $request->sub_specialization_id;
                    $provider->governments_id = $request->government_id;
                    if ($request->hasFile('commercial_register')) {
                        $file = $request->file('commercial_register');
                        $filename = 'files/providers/' . time() . '.' . $request->commercial_register->extension();
                        $file->move(public_path('files/providers'), $filename);
                        $provider->commercial_register = $filename;
                    }

                    if ($request->hasFile('tax_card')) {
                        $file = $request->file('tax_card');
                        $filename = 'files/providers/' . time() . '.' . $request->tax_card->extension();
                        $file->move(public_path('files/providers'), $filename);
                        $provider->tax_card = $filename;
                    }
                    $provider->bio = $request->bio;
                    $provider->save();
                    break;
                case 'admin':
                    $user->assignRole('admin');
                    $admin = new Admin();
                    $admin->user_id = $user->id;
                    $admin->governments_id = $request->government_id;
                    $admin->save();
                    break;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Register successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {

            if (str_contains($e->getMessage(), 'The email has already been taken.')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This email already exists. Please choose another one.',
                    'error' => $e->getMessage(),
                ], 401);
            } else if (str_contains($e->getMessage(), 'The phone has already been taken.')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This phone number already exists. Please choose another one.',
                    'error' => $e->getMessage(),
                ], 401);
            } else if (str_contains($e->getMessage(), 'The password must be at least 6 characters.')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password must be at least 6 characters.',
                    'error' => $e->getMessage(),
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation error.',
                    'error' => $e->getMessage(),
                ], 401);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => "success",
                'message' => "Logout Successfully",
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'country_code' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $user = User::findOrFail(Auth::user()->id);
            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->country_code = $request->country_code ?? $user->country_code;
            if ($request->image) {
                if (file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $imageName = 'images/users/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/users'), $imageName);
                $user->image = $imageName;
            }
            $user->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                "old_password" => "required|min:6",
                "new_password" => "required|min:6",
            ]);

            $user = User::findOrFail(Auth::user()->id)->first();
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->old_password == $request->new_password) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'New password must be different from old password.',
                    ], 401);
                }
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password reset successfully.',
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Old Password does not correct.',
                ], 401);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $request->email)->first();

            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status' => "success",
                'message' => "Password Reset Successfully",
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
