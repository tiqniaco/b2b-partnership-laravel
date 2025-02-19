<?php

namespace App\Http\Controllers;

use App\Models\PreviousWorkImage;
use Illuminate\Http\Request;

class PreviousWorkImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'provider_previous_work_id' => 'required|exists:provider_previous_works,id',
            ]);

            $previousWorkImages = PreviousWorkImage::where('provider_previous_work_id', $request->provider_previous_work_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'images' => $previousWorkImages
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'provider_previous_work_id' => 'required|exists:provider_previous_works,id',
                'images' => 'required|array',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);

            $images = $request->file('images');
            foreach ($images as $image) {
                $imageName = 'images/previous_work_images/' . time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('images/previous_work_images'), $imageName);
                $previousWorkImage = new PreviousWorkImage();
                $previousWorkImage->provider_previous_work_id = $request->provider_previous_work_id;
                $previousWorkImage->image = $imageName;
                $previousWorkImage->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
            ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);

            $previousWorkImage = PreviousWorkImage::findOrFail($id);
            if ($request->hasFile('image')) {
                if (file_exists(public_path($previousWorkImage->image))) {
                    unlink(public_path($previousWorkImage->image));
                }
                $imageName = 'images/previous_work_images/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/previous_work_images'), $imageName);
                $previousWorkImage->image = $imageName;
            }
            $previousWorkImage->save();

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
            $previousWorkImage = PreviousWorkImage::findOrFail($id);
            if (file_exists(public_path($previousWorkImage->image))) {
                unlink(public_path($previousWorkImage->image));
            }
            $previousWorkImage->delete();

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
