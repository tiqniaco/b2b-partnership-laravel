<?php

namespace App\Http\Controllers;

use App\Models\ProviderService;

class HomeController extends Controller
{
    public function topServices()
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
                ->orderBy('provider_services.rating', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $providerService,
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

    public function newServices()
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
                ->orderBy('provider_services.created_at', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $providerService,
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
