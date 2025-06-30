<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BagContent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class BagContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $bagContents = BagContent::all();
            return response()->json([
                'message' => 'Bag contents fetched successfully',
                'data' => $bagContents,
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
            $validator = Validator::make($request->all(), [
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/bag_contents'), $imageName);

            $bagContent = BagContent::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'image' => 'images/bag_contents/' . $imageName,
            ]);

            return response()->json([
                'message' => 'Bag content created successfully',
                'data' => $bagContent,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating bag content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BagContent $bagContent)
    {
        try {
            return response()->json([
                'message' => 'Bag content fetched successfully',
                'data' => $bagContent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Bag content not found',
                'error' => 'The requested bag content does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error fetching bag content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BagContent $bagContent)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                if ($bagContent->image) {
                    // delete the old image
                    unlink(public_path($bagContent->image));
                }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/bag_contents'), $imageName);
                $bagContent->image = 'images/bag_contents/' . $imageName;
            }

            $bagContent->name_en = $request->name_en;
            $bagContent->name_ar = $request->name_ar;
            $bagContent->save();

            return response()->json([
                'message' => 'Bag content updated successfully',
                'data' => $bagContent,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Bag content not found',
                'error' => 'The requested bag content does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating bag content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bagContent)
    {
        try {
            $bagContent = BagContent::findOrFail($bagContent);
            if ($bagContent->image) {
                unlink(public_path($bagContent->image));
            }
            $bagContent->delete();
            return response()->json([
                'message' => 'Bag content deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Bag content not found',
                'error' => 'The requested bag content does not exist'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting bag content',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
