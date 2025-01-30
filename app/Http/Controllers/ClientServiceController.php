<?php

namespace App\Http\Controllers;

use App\Models\ClientServices;
use Illuminate\Http\Request;

class ClientServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clientsServices = ClientServices::select(
                'client_services.id',
                'client_services.client_id',
                'client_services.governments_id',
                'client_services.sub_specialization_id',
                'client_services.address',
                'client_services.description',
                'client_services.image',
                'client_services.start_price',
                'client_services.end_price',
                'client_services.duration',
                'client_services.file',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'client_services.created_at',
                'client_services.updated_at',
            )
                ->join('sub_specializations', 'client_services.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->join('governments', 'client_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->paginate(12);

            return response()->json(
                $clientsServices,
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
                'client_id' => 'required|integer|exists:clients,id',
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

            $clientService = new ClientServices();
            $clientService->client_id = $request->client_id;
            $clientService->governments_id = $request->governments_id;
            $clientService->sub_specialization_id = $request->sub_specialization_id;
            $clientService->address = $request->address;
            $clientService->description = $request->description;
            $clientService->start_price = $request->start_price;
            $clientService->end_price = $request->end_price;
            $clientService->duration = $request->duration;
            if ($request->hasFile('image')) {
                $imageName = 'images/client_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/client_services'), $imageName);
                $clientService->image = $imageName;
            }
            if ($request->hasFile('file')) {
                $file = 'files/client_services/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/client_services'), $file);
                $clientService->file = $file;
            }
            $clientService->save();

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
            $clientService = ClientServices::select(
                'client_services.id',
                'client_services.client_id',
                'client_services.governments_id',
                'client_services.sub_specialization_id',
                'client_services.address',
                'client_services.description',
                'client_services.image',
                'client_services.start_price',
                'client_services.end_price',
                'client_services.duration',
                'client_services.file',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'client_services.created_at',
                'client_services.updated_at',
            )
                ->join('sub_specializations', 'client_services.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->join('governments', 'client_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->where('client_services.id', $id)
                ->first();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $clientService,
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

            $clientService = ClientServices::findOrFail($id);
            $clientService->governments_id = $request->governments_id ?? $clientService->governments_id;
            $clientService->address = $request->address ?? $clientService->address;
            $clientService->description = $request->description ?? $clientService->description;
            $clientService->start_price = $request->start_price ?? $clientService->start_price;
            $clientService->end_price = $request->end_price ?? $clientService->end_price;
            $clientService->duration = $request->duration ?? $clientService->duration;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($clientService->image))) {
                    unlink(public_path($clientService->image));
                }
                $imageName = 'images/client_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/client_services'), $imageName);
                $clientService->image = $imageName;
            }
            if ($request->hasFile('file')) {
                if (file_exists(public_path($clientService->file))) {
                    unlink(public_path($clientService->file));
                }
                $file = 'files/client_services/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/client_services'), $file);
                $clientService->file = $file;
            }
            $clientService->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                    'data' => $clientService,
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
            $clientService = ClientServices::findOrFail($id);
            if (file_exists(public_path($clientService->image))) {
                unlink(public_path($clientService->image));
            }
            if ($clientService->file) {
                if (file_exists(public_path($clientService->file))) {
                    unlink(public_path($clientService->file));
                }
            }

            $clientService->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data deleted successfully.',
                    'data' => $clientService,
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