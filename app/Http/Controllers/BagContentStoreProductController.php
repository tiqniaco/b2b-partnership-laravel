<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BagContentStoreProduct;


class BagContentStoreProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'nullable|exists:store_products,id',
            ]);
            if ($request->product_id){
                $data = BagContentStoreProduct::where('store_product_id', $request->product_id)->get();
            } else {
                $data = BagContentStoreProduct::all();
            }
            
            return response()->json([
                'message' => 'Data fetched successfully',
                'data' => $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching bag contents',
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
                'bag_content_id' => 'required|exists:bag_contents,id',

            ]);

            $check = BagContentStoreProduct::where('store_product_id', $request->product_id)
            ->where('bag_content_id',$request->bag_content_id )->first();

            if($check){
                return response()->json([
                    'status' => "Error",
                    'message' => 'This Bag content is already in Product',
                ], 400);
            }

            $data = new BagContentStoreProduct();
            $data->store_product_id = $request->product_id;
            $data->bag_content_id = $request->bag_content_id;
            $data->save();

            
            return response()->json([
                'status' => "Success",
                'message' => 'Data created successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching bag contents',
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:store_products,id',
                'bag_content_id' => 'required|exists:bag_contents,id',

            ]);
            $bagContentStoreProduct = BagContentStoreProduct::where('store_product_id', $request->product_id)
            ->where('bag_content_id',$request->bag_content_id )->first();
            if (!$bagContentStoreProduct) {
                return response()->json([
                    'message' => 'Bag Content Store Product not found',
                    'error' => 'The requested does not exist'
                ], 404);
            }
            
            $bagContentStoreProduct->delete();
            return response()->json([
                'message' => 'Data deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Bag Content Store Product not found',
                'error' => 'The requested does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting item',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
