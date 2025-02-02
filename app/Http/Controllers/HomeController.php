<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\ProviderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function topServices()
    {
        try {
            $userId = Auth::user()->id;
            $providerService = ProviderService::select(
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
                DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorite_services WHERE favorite_services.user_id = $userId AND favorite_services.provider_service_id = provider_services.id) THEN 1 ELSE 0 END) as is_favorite"),
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
            $userId = Auth::user()->id;
            $providerService = ProviderService::select(
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
                DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorite_services WHERE favorite_services.user_id = $userId AND favorite_services.provider_service_id = provider_services.id) THEN 1 ELSE 0 END) as is_favorite"),
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

    public function newJobs()
    {
        try {
            $jobs = Job::select(
                'jobs.id',
                'jobs.job_title',
                'jobs.job_description',
                'jobs.image',
                'jobs.is_urgent',
                'jobs.start_price',
                'jobs.end_price',
                'jobs.salary_type',
                'jobs.contract_type',
                'jobs.years_of_experience',
                'jobs.gender',
                'jobs.qualifications',
                'jobs.key_responsibilities',
                'jobs.skill_and_experience',
                'jobs.job_skills',
                'jobs.job_location',
                'jobs.expiration_date',
                'providers.id as provider_id',
                'users.name as provider_name',
                'users.email as provider_email',
                'users.phone as provider_phone',
                'users.country_code as provider_country_code',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'countries.flag as country_flag',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_en as specialization_name',
                'sub_specializations.name_ar as specialization_name_ar',
                'jobs.created_at',
                'jobs.updated_at'
            )
                ->join('providers', 'providers.id', '=', 'jobs.provider_id')
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('governments', 'governments.id', '=', 'jobs.governments_id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('sub_specializations', 'sub_specializations.id', '=', 'jobs.sub_specialization_id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->orderBy('jobs.is_urgent', 'desc')
                ->orderBy('jobs.created_at', 'desc')
                ->limit(5)
                ->get();
            if ($jobs->isEmpty()) {
                return response()->json([
                    'data' => [],
                ], 200);
            }
            return response()->json(
                $jobs,
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
