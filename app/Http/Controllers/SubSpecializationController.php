<?php

namespace App\Http\Controllers;

use App\Models\SubSpecialization;
use Illuminate\Http\Request;

class SubSpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'specialization_id' => 'required|exists:specializations,id',
            ]);
            $subSpecialization = SubSpecialization::where('parent_id', $request->specialization_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $subSpecialization,
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_en' => 'required|string',
                'name_ar' => 'required|string',
                'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
                'specialization_id' => 'required|exists:specializations,id',
            ]);

            $subSpecialization = new SubSpecialization();
            $subSpecialization->name_en = $request->name_en;
            $subSpecialization->name_ar = $request->name_ar;
            if ($request->hasFile('image')) {
                $imageName = 'images/sub_specializations/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/sub_specializations'), $imageName);
                $subSpecialization->image = $imageName;
            }
            $subSpecialization->parent_id = $request->specialization_id;
            $subSpecialization->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $subSpecialization = SubSpecialization::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $subSpecialization,
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'name_en' => 'nullable|string',
                'name_ar' => 'nullable|string',
                'image' => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
            ]);

            $subSpecialization = SubSpecialization::findOrFail($id);
            $subSpecialization->name_en = $request->name_en ?? $subSpecialization->name_en;
            $subSpecialization->name_ar = $request->name_ar ?? $subSpecialization->name_ar;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($subSpecialization->image))) {
                    unlink(public_path($subSpecialization->image));
                }
                $imageName = 'images/sub_specializations/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/sub_specializations'), $imageName);
                $subSpecialization->image = $imageName;
            }
            $subSpecialization->save();

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
            $subSpecialization = SubSpecialization::findOrFail($id);
            if ($subSpecialization->image) {
                if (file_exists(public_path($subSpecialization->image))) {
                    unlink(public_path($subSpecialization->image));
                }
            }
            $subSpecialization->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
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