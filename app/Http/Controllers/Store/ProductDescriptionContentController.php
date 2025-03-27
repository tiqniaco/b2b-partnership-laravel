<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDescriptionContent;

class ProductDescriptionContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'title_id' => 'required|exists:product_description_titles,id',
            ]);

            $contents = ProductDescriptionContent::where('title_id', $request->title_id)->get();

            if ($contents->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No data found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $contents
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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
                'title_id' => 'required|exists:product_description_titles,id',
                'content_ar' => 'required|string',
                'content_en' => 'required|string',
            ]);

            $content = new ProductDescriptionContent();
            $content->title_id = $request->title_id;
            $content->content_ar = $request->content_ar;
            $content->content_en = $request->content_en;
            $content->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data saved successfully.',
                'data' => $content
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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
                'content_ar' => 'nullable|string',
                'content_en' => 'nullable|string',
            ]);

            $content = ProductDescriptionContent::findOrFail($id);
            $content->content_ar = $request->content_ar ?? $content->content_ar;
            $content->content_en = $request->content_en ?? $content->content_en;
            $content->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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
            $content = ProductDescriptionContent::findOrFail($id);
            $content->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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
