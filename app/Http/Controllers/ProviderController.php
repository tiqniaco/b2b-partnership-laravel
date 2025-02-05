<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $providers = DB::table('provider_details')
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $provider = DB::table('provider_details')
                ->where('provider_id', $id)
                ->first();


            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $provider,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $provider = Provider::findOrFail($id);
            $user = User::findOrFail($provider->user_id);

            $provider->delete();
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
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

    public function services($id)
    {
        try {
            $provider = Provider::find($id);

            if (!$provider) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Provider not found.',
                ], 404);
            }
            $userId =  Auth::user()->id;
            $services = ProviderService::select(
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
                DB::raw("
                    COALESCE(
                        (SELECT 1 FROM favorite_services 
                        WHERE favorite_services.user_id = $userId 
                        AND favorite_services.provider_service_id = provider_services.id 
                        LIMIT 1), 0
                    ) as is_favorite
                "),
                'provider_services.created_at',
                'provider_services.updated_at',
            )
                ->join('governments', 'provider_services.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('specializations', 'provider_services.sub_specialization_id', '=', 'specializations.id')
                ->leftJoin('sub_specializations', 'specializations.id', '=', 'sub_specializations.parent_id')                // ->distinct()
                ->where('provider_services.provider_id', $id)
                ->orderBy('provider_services.created_at', 'desc')
                ->get();

            $all = [];

            foreach ($services as $service) {
                if (!in_array($service->id, array_column($all, 'id'))) {
                    $all[] = $service;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $all,
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
