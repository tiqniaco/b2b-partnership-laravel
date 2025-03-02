<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $specialization = Specialization::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $specialization,
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
                'image' => "required|image|mimes:jpeg,png,jpg,gif,svg",
            ]);

            $specialization = new Specialization();
            $specialization->name_en = $request->name_en;
            $specialization->name_ar = $request->name_ar;
            if ($request->hasFile('image')) {
                $imageName = 'images/specializations/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/specializations'), $imageName);
                $specialization->image = $imageName;
            }
            $specialization->save();

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
            $specialization = Specialization::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $specialization,
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

            $specialization = Specialization::findOrFail($id);
            $specialization->name_en = $request->name_en ?? $specialization->name_en;
            $specialization->name_ar = $request->name_ar ?? $specialization->name_ar;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($specialization->image))) {
                    unlink(public_path($specialization->image));
                }
                $imageName = 'images/specializations/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/specializations'), $imageName);
                $specialization->image = $imageName;
            }
            $specialization->save();

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
            $specialization = Specialization::findOrFail($id);
            if (file_exists(public_path($specialization->image))) {
                unlink(public_path($specialization->image));
            }
            $specialization->delete();

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

    public function providers(Request $request)
    {
        try {
            $request->validate([
                "specialization_id" => "nullable|exists:specializations,id",
                "sub_specialization_id" => "nullable|exists:sub_specializations,id",
                "country_id" => "nullable|exists:countries,id",
                "government_id" => "nullable|exists:governments,id",
                "search" => "nullable|string",
                "rate" => "nullable|integer|min:0|max:5",
            ]);

            $providers = DB::table('provider_details_filter_view')
                ->distinct() // Ensures unique rows
                ->when($request->filled('specialization_id'), function ($query) use ($request) {
                    return $query->where('specialization_id', $request->specialization_id);
                })
                ->when($request->filled('sub_specialization_id'), function ($query) use ($request) {
                    return $query->where('sub_specialization_id', $request->sub_specialization_id);
                })
                ->when($request->filled('search'), function ($query) use ($request) {
                    $searchTerm = '%' . $request->search . '%';
                    return $query->where(function ($q) use ($searchTerm) {
                        $q->where('name', 'like', $searchTerm)
                            ->orWhere('provider_service_name_ar', 'like', $searchTerm)
                            ->orWhere('provider_service_name_en', 'like', $searchTerm);
                    });
                })
                ->when($request->filled('country_id'), function ($query) use ($request) {
                    return $query->where('country_id', $request->country_id);
                })
                ->when($request->filled('government_id'), function ($query) use ($request) {
                    return $query->where('government_id', $request->government_id);
                })
                ->when($request->filled('rate'), function ($query) use ($request) {
                    return $query->where('rating', '=', $request->rate);
                })
                ->orderBy('created_at', 'desc')
                ->orderBy('rating', 'desc')
                ->paginate(12);

            return response()->json($providers, 200);
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