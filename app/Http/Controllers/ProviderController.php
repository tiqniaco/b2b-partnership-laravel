<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderService;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $providers = Provider::select(
                'users.id as user_id',
                'users.name as name',
                'users.email as email',
                'users.country_code as country_code',
                'users.phone as phone',
                'providers.id as provider_id',
                'providers.image as image',
                'providers.commercial_register as commercial_register',
                'providers.tax_card as tax_card',
                'providers.bio as bio',
                'providers.rating as rating',
                'provider_types.name_ar as provider_type_name_ar',
                'provider_types.name_en as provider_type_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'providers.created_at as created_at',
                'providers.updated_at as updated_at',
            )
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('provider_types', 'providers.provider_types_id', '=', 'provider_types.id')
                ->join('sub_specializations', 'providers.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('governments', 'providers.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
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
     $allServices = ProviderService::where('provider_id', $id)->get();
            $rating = 0;
            foreach ($allServices as $service) {
                $rating += $service->rating;
            }
            $provider = Provider::findOrFail($id);
            $provider->rating = $rating / $allServices->count();
            $provider->save();

            $provider = Provider::select(
                'users.id as user_id',
                'users.name as name',
                'users.email as email',
                'users.country_code as country_code',
                'users.phone as phone',
                'providers.id as provider_id',
                'providers.image as image',
                'providers.commercial_register as commercial_register',
                'providers.tax_card as tax_card',
                'providers.bio as bio',
                'providers.rating as rating',
                'provider_types.name_ar as provider_type_name_ar',
                'provider_types.name_en as provider_type_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_ar as sub_specialization_name_ar',
                'sub_specializations.name_en as sub_specialization_name_en',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'providers.created_at as created_at',
                'providers.updated_at as updated_at',
            )
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('provider_types', 'providers.provider_types_id', '=', 'provider_types.id')
                ->join('sub_specializations', 'providers.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('governments', 'providers.governments_id', '=', 'governments.id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->where('providers.id', $id)
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
}