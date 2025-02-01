<?php

namespace App\Http\Controllers;

use App\Models\ProviderService;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $providerServices = ProviderService::select(
                'provider_services.id',
                'provider_services.provider_id',
                'provider_services.governments_id',
                'provider_services.sub_specialization_id',
                'provider_services.address',
                'provider_services.description',
                'provider_services.image',
                'provider_services.start_price',
                'provider_services.end_price',
                'provider_services.duration',
                'provider_services.file',
                'provider_services.rating',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'provider_services.created_at',
                'provider_services.updated_at',
            )
                ->join('sub_specializations', 'provider_services.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->join('governments', 'provider_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->paginate(12);

            return response()->json(
                $providerServices,
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
                'provider_id' => 'required|integer|exists:providers,id',
                'governments_id' => 'required|integer|exists:governments,id',
                'sub_specialization_id' => 'required|integer|exists:sub_specializations,id',
                'address' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'start_price' => 'required|numeric',
                'end_price' => 'required|numeric',
                'duration' => 'required|string|max:255',
                'file' => 'nullable|file|mimes:pdf|max:50000',
            ]);

            $providerService = new ProviderService();
            $providerService->provider_id = $request->provider_id;
            $providerService->governments_id = $request->governments_id;
            $providerService->sub_specialization_id = $request->sub_specialization_id;
            $providerService->address = $request->address;
            $providerService->description = $request->description;
            $providerService->start_price = $request->start_price;
            $providerService->end_price = $request->end_price;
            $providerService->duration = $request->duration;
            if ($request->hasFile('image')) {
                $imageName = 'images/$provider_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/$provider_services'), $imageName);
                $providerService->image = $imageName;
            }
            if ($request->hasFile('file')) {
                $file = 'files/$provider_services/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/$provider_services'), $file);
                $providerService->file = $file;
            }
            $providerService->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                ],
                201
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
            $providerService = ProviderService::select(
                'provider_services.id',
                'provider_services.provider_id',
                'provider_services.governments_id',
                'provider_services.sub_specialization_id',
                'provider_services.address',
                'provider_services.description',
                'provider_services.image',
                'provider_services.start_price',
                'provider_services.end_price',
                'provider_services.duration',
                'provider_services.file',
                'provider_services.rating',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'provider_services.created_at',
                'provider_services.updated_at',
            )
                ->join('sub_specializations', 'provider_services.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->join('governments', 'provider_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->where('provider_services.id', $id)
                ->first();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $providerService,
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
                'governments_id' => 'nullable|integer|exists:governments,id',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'start_price' => 'nullable|numeric',
                'end_price' => 'nullable|numeric',
                'duration' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:pdf|max:50000',
            ]);

            $providerService = ProviderService::findOrFail($id);
            $providerService->governments_id = $request->governments_id ?? $providerService->governments_id;
            $providerService->address = $request->address ?? $providerService->address;
            $providerService->description = $request->description ?? $providerService->description;
            $providerService->start_price = $request->start_price ?? $providerService->start_price;
            $providerService->end_price = $request->end_price ?? $providerService->end_price;
            $providerService->duration = $request->duration ?? $providerService->duration;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($providerService->image))) {
                    unlink(public_path($providerService->image));
                }
                $imageName = 'images/$provider_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/$provider_services'), $imageName);
                $providerService->image = $imageName;
            }
            if ($request->hasFile('file')) {
                if (file_exists(public_path($providerService->file))) {
                    unlink(public_path($providerService->file));
                }
                $file = 'files/$provider_services/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/$provider_services'), $file);
                $providerService->file = $file;
            }
            $providerService->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                    'data' => $providerService,
                ],
                201
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
            $providerService = ProviderService::findOrFail($id);
            if (file_exists(public_path($providerService->image))) {
                unlink(public_path($providerService->image));
            }
            if ($providerService->file) {
                if (file_exists(public_path($providerService->file))) {
                    unlink(public_path($providerService->file));
                }
            }

            $providerService->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data deleted successfully.',
                    'data' => $providerService,
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