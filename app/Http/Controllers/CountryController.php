<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $countries = Country::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $countries,
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
                'flag' => "required|image|mimes:jpeg,png,jpg,gif,svg",
                'code' => 'required|string|max:10',
                'phone_length' => 'required|integer',
            ], 200);

            $country = new Country();
            $country->name_en = $request->name_en;
            $country->name_ar = $request->name_ar;
            $country->code = $request->code;
            $country->phone_length = $request->phone_length;
            if ($request->hasFile('flag')) {
                $imageName = 'images/countries/' . time() . '.' . $request->flag->extension();
                $request->flag->move(public_path('images/countries'), $imageName);
                $country->flag = $imageName;
            }
            $country->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $country = Country::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $country,
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
                'flag' => "image|mimes:jpeg,png,jpg,gif,svg",
                'code' => 'nullable|string|max:10',
                'phone_length' => 'nullable|integer',
            ], 200);

            $country = Country::findOrFail($id);
            $country->name_en = $request->name_en ?? $country->name_en;
            $country->name_ar = $request->name_ar ?? $country->name_ar;
            $country->code = $request->code ?? $country->code;
            $country->phone_length = $request->phone_length ?? $country->phone_length;
            if ($request->hasFile('flag')) {
                unlink(public_path($country->flag));
                $imageName = 'images/countries/' . time() . '.' . $request->flag->extension();
                $request->flag->move(public_path('images/countries'), $imageName);
                $country->flag = $imageName;
            }
            $country->save();

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
            $country = Country::findOrFail($id);
            unlink(public_path($country->flag));
            $country->delete();

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
