<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ProductDescriptionTitle;
use Illuminate\Http\Request;

class ProductDescriptionTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:store_products,id',
            ]);

            $titles = ProductDescriptionTitle::where('product_id', $request->product_id)->get();

            if ($titles->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No data found.',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $titles
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
                'product_id' => 'required|exists:store_products,id',
                'title_ar' => 'required|string',
                'title_en' => 'required|string',
            ]);

            $title = new ProductDescriptionTitle();
            $title->product_id = $request->product_id;
            $title->title_ar = $request->title_ar;
            $title->title_en = $request->title_en;
            $title->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data saved successfully.',
                'data' => $title
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $title = ProductDescriptionTitle::findOrFail($id);
            $title->contents;

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $title
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
                'title_ar' => 'nullable|string',
                'title_en' => 'nullable|string',
            ]);

            $title = ProductDescriptionTitle::findOrFail($id);
            $title->title_ar = $request->title_ar ?? $title->title_ar;
            $title->title_en = $request->title_en ?? $title->title_en;
            $title->save();

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
            $title = ProductDescriptionTitle::findOrFail($id);
            $title->delete();

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
