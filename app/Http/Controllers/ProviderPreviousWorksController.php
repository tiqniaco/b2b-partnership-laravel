<?php

namespace App\Http\Controllers;

use App\Models\ProviderPreviousWork;
use Illuminate\Http\Request;

class ProviderPreviousWorksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'provider_id' => 'required|exists:providers,id',
            ]);

            $providerPreviousWorks = ProviderPreviousWork::where('provider_id', $request->provider_id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $providerPreviousWorks,
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
                'provider_id' => 'required|exists:providers,id',
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);

            $providerPreviousWork = new ProviderPreviousWork();
            $providerPreviousWork->provider_id = $request->provider_id;
            $providerPreviousWork->title_ar = $request->title_ar;
            $providerPreviousWork->title_en = $request->title_en;
            $providerPreviousWork->description = $request->description;
            if ($request->hasFile('image')) {
                $imageName = 'images/provider_previous_works/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/provider_previous_works'), $imageName);
                $providerPreviousWork->image = $imageName;
            }
            $providerPreviousWork->save();


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
        try {
            $providerPreviousWork = ProviderPreviousWork::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
                'data' => $providerPreviousWork,
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
                'title_ar' => 'nullable|string|max:255',
                'title_en' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);

            $providerPreviousWork = ProviderPreviousWork::findOrFail($id);
            $providerPreviousWork->title_ar = $request->title_ar ?? $providerPreviousWork->title_ar;
            $providerPreviousWork->title_en = $request->title_en ?? $providerPreviousWork->title_en;
            $providerPreviousWork->description = $request->description ?? $providerPreviousWork->description;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($providerPreviousWork->image))) {
                    unlink(public_path($providerPreviousWork->image));
                }
                $imageName = 'images/provider_previous_works/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/provider_previous_works'), $imageName);
                $providerPreviousWork->image = $imageName;
            }
            $providerPreviousWork->save();


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
    { {
            try {
                $providerPreviousWork = ProviderPreviousWork::findOrFail($id);

                if (file_exists(public_path($providerPreviousWork->image))) {
                    unlink(public_path($providerPreviousWork->image));
                }
                $providerPreviousWork->delete();

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
}