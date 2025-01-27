<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\ServiceProvider;
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
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successfully.',
                    'user' => $user,
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
                'phone' => 'required|string|unique:users,phone_number',
                'role' => 'required|in:client,service_provider,admin',
                'government_id' => 'required|string|unique:users,government_id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'sub_specialization_id' => 'nullable|exists:sub_specializations,id',
                'service_provider_type_id' => 'nullable|exists:service_provider_types,id',
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->country_code = $request->country_code;
            $user->save();

            switch ($request->role) {
                case 'client':
                    $user->assignRole('client');
                    $client = new Client();
                    $client->user_id = $user->id;
                    $client->governments_id = $request->government_id;
                    if ($request->hasFile('image')) {
                        $imageName = 'images/clients/' . time() . '.' . $request->image->extension();
                        $request->image->move(public_path('images/clients'), $imageName);
                        $client->image = $imageName;
                    }
                    $client->save();
                    break;
                case 'service_provider':
                    $user->assignRole('service_provider');
                    $serviceProvider = new ServiceProvider();
                    $serviceProvider->user_id = $user->id;
                    $serviceProvider->service_provider_type_id = $request->service_provider_type_id;
                    $serviceProvider->sub_specialization_id = $request->sub_specialization_id;
                    $serviceProvider->governments_id = $request->government_id;
                    if ($request->hasFile('image')) {
                        $imageName = 'images/service_providers/' . time() . '.' . $request->image->extension();
                        $request->image->move(public_path('images/service_providers'), $imageName);
                        $serviceProvider->image = $imageName;
                    }
                    $serviceProvider->save();
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
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 200);
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

    public function forgetPassword(Request $request) {}
}
