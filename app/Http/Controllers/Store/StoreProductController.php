<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\StoreProduct;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = StoreProduct::paginate(12);

            return response()->json(
                $products,
                200,
            );
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
                'category_id' => 'required|exists:store_categories,id',
                'title_ar' => 'required|string',
                'title_en' => 'required|string',
                'description_ar' => 'required|string',
                'description_en' => 'required|string',
                'file' => 'required|file|mimes:pdf,doc,docx,excel,csv,txt,zip,rar,ppt,pptx,jpg,jpeg,png,gif,svg|max:50000',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $product = new StoreProduct();
            $product->category_id = $request->category_id;
            $product->title_ar = $request->title_ar;
            $product->title_en = $request->title_en;
            $product->description_ar = $request->description_ar;
            $product->description_en = $request->description_en;
            if ($request->hasFile('file')) {
                $fileName = 'files/store_products/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/store_products'), $fileName);
                $product->file = $fileName;
            }
            $product->price = $request->price;
            $product->discount = $request->discount;
            if ($request->hasFile('image')) {
                $imageName = 'images/store_products/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/store_products'), $imageName);
                $product->image = $imageName;
            }
            $product->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                ],
                201,
            );
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
            $product = StoreProduct::findOrFail($id);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $product,
                ],
                200,
            );
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
                'category_id' => 'nullable|exists:store_categories,id',
                'title_ar' => 'nullable|string',
                'title_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,excel,csv,txt,zip,rar,ppt,pptx,jpg,jpeg,png,gif,svg|max:50000',
                'price' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $product = new StoreProduct();
            $product->category_id = $request->category_id ?? $product->category_id;
            $product->title_ar = $request->title_ar ?? $product->title_ar;
            $product->title_en = $request->title_en ?? $product->title_en;
            $product->description_ar = $request->description_ar ?? $product->description_ar;
            $product->description_en = $request->description_en ?? $product->description_en;
            if ($request->hasFile('file')) {
                if (file_exists(public_path($product->file))) {
                    unlink(public_path($product->file));
                }
                $fileName = 'files/store_products/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/store_products'), $fileName);
                $product->file = $fileName;
            }
            $product->price = $request->price ?? $product->price;
            $product->discount = $request->discount ?? $product->discount;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
                $imageName = 'images/store_products/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/store_products'), $imageName);
                $product->image = $imageName;
            }
            $product->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                ],
                201,
            );
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
            $product = StoreProduct::findOrFail($id);
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data deleted successfully.',
                ],
                200,
            );
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
