<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $admins = DB::table("admin_details_view")->get();

            return response()->json([
                'status' => 'success',
                'data' => $admins
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $admin = DB::table("admin_details_view")
                ->where('admin_id', $id)
                ->first();
            if (!$admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $admin
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                "name" => "nullable|string",
                "email" => "nullable|email",
                "country_code" => "nullable|string|max:3",
                "phone" => "nullable|string",
                "government_id" => "nullable|exists:governments,id",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
            ]);

            $admin = Admin::findOrFail($id);
            $user = User::findOrFail($admin->user_id);

            if ($request->hasFile('image')) {
                if (file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $imageName = 'images/admins/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/admins'), $imageName);
                $user->image = $imageName;
            }

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->country_code = $request->country_code ?? $user->country_code;
            $admin->governments_id = $request->government_id ?? $admin->governments_id;

            $user->save();
            $admin->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $user = User::findOrFail($admin->user_id);

            $admin->delete();
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
            ]);
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