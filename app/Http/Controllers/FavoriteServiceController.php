<?php

namespace App\Http\Controllers;

use App\Models\FavoriteService;
use Illuminate\Http\Request;

class FavoriteServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                "user_id" => "required|exists:users,id",
            ]);

            $favoriteServices = FavoriteService::select(
                'favorite_services.id',
                'favorite_services.user_id',
                'favorite_services.provider_service_id',
                'provider_services.id',
                'provider_services.provider_id',
                'provider_services.name_ar',
                'provider_services.name_en',
                'provider_services.address',
                'provider_services.description',
                'provider_services.image',
                'provider_services.price',
                'provider_services.rating',
                'provider_services.overview',
                'provider_services.video',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'provider_services.governments_id',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'provider_services.sub_specialization_id',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'provider_services.created_at',
                'provider_services.updated_at',
            )
                ->join('provider_services', 'favorite_services.provider_service_id', '=', 'provider_services.id')
                ->join('sub_specializations', 'provider_services.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->join('governments', 'provider_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->where('favorite_services.user_id', $request->user_id)
                ->get();

            if ($favoriteServices->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No data found.',
                    'data' => $favoriteServices
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $favoriteServices
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
                "user_id" => "required|exists:users,id",
                "provider_service_id" => "required|exists:provider_services,id",
            ]);

            $check = FavoriteService::where('user_id', $request->user_id)
                ->where('provider_service_id', $request->provider_service_id)
                ->first();

            if ($check) {
                $check->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Service removed from favorites successfully.',
                ], 200);
            }

            $favoriteService = new FavoriteService();
            $favoriteService->user_id = $request->user_id;
            $favoriteService->provider_service_id = $request->provider_service_id;
            $favoriteService->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Service added to favorites successfully.',
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
