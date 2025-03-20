<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Provider;
use App\Models\ProviderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    public function topServices()
    {
        try {
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
            ], 404);
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
            ], 404);
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
            ], 404);
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
    public function topProviders(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);

            $userId = $request->user_id;

            $providers = DB::table('provider_details')
                ->select(
                    'provider_details.*',
                    DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorites_view WHERE favorites_view.user_id = $userId AND favorites_view.provider_id = provider_details.provider_id) THEN 1 ELSE 0 END) as is_favorite")
                )
                ->orderByDesc('rating')
                ->limit(5)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $providers,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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

    public function countriesProviders()
    {
        try {
            $providersData = DB::table('countries')
                ->join('governments', 'countries.id', '=', 'governments.country_id')  // Join governments with countries
                ->join('providers', 'governments.id', '=', 'providers.governments_id')  // Join providers with governments
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('provider_types', 'providers.provider_types_id', '=', 'provider_types.id')
                ->join('sub_specializations', 'providers.sub_specialization_id', '=', 'sub_specializations.id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->select(
                    'countries.name_ar AS country_name_ar',
                    'countries.name_en AS country_name_en',
                    'users.id AS user_id',
                    'users.name AS name',
                    'users.email AS email',
                    'users.country_code AS country_code',
                    'users.phone AS phone',
                    'users.image AS image',
                    'providers.id AS provider_id',
                    'providers.commercial_register AS commercial_register',
                    'providers.tax_card AS tax_card',
                    'providers.bio AS bio',
                    'providers.rating AS rating',
                    'provider_types.name_ar AS provider_type_name_ar',
                    'provider_types.name_en AS provider_type_name_en',
                    'specializations.id AS specialization_id',
                    'specializations.name_ar AS specialization_name_ar',
                    'specializations.name_en AS specialization_name_en',
                    'sub_specializations.id AS sub_specialization_id',
                    'sub_specializations.name_ar AS sub_specialization_name_ar',
                    'sub_specializations.name_en AS sub_specialization_name_en',
                    'countries.id AS country_id',
                    'governments.name_ar AS government_name_ar',
                    'governments.name_en AS government_name_en',
                    'providers.created_at AS created_at',
                    'providers.updated_at AS updated_at',
                )
                ->orderByDesc('providers.rating')  // Order providers by rating (top rated first)
                ->get()
                ->groupBy('country_id');  // Group by country_id

            $formattedData = $providersData->map(function ($countryGroup) {
                $country = $countryGroup->first();  // Get the first entry for country data

                // Limit to top 5 providers for each country
                $topProviders = $countryGroup->take(5)->map(function ($provider) {
                    $userId = Auth::user()->id;
                    return [
                        'user_id' => $provider->user_id,
                        'name' => $provider->name,
                        'email' => $provider->email,
                        'country_code' => $provider->country_code,
                        'phone' => $provider->phone,
                        'image' => $provider->image,
                        'provider_id' => $provider->provider_id,
                        'commercial_register' => $provider->commercial_register,
                        'tax_card' => $provider->tax_card,
                        'bio' => $provider->bio,
                        'rating' => $provider->rating,
                        'provider_type_name_ar' => $provider->provider_type_name_ar,
                        'provider_type_name_en' => $provider->provider_type_name_en,
                        'specialization_id' => $provider->specialization_id,
                        'specialization_name_ar' => $provider->specialization_name_ar,
                        'specialization_name_en' => $provider->specialization_name_en,
                        'sub_specialization_id' => $provider->sub_specialization_id,
                        'sub_specialization_name_ar' => $provider->sub_specialization_name_ar,
                        'sub_specialization_name_en' => $provider->sub_specialization_name_en,
                        'country_id' => $provider->country_id,
                        'country_name_ar' => $provider->country_name_ar,
                        'country_name_en' => $provider->country_name_en,
                        'government_name_ar' => $provider->government_name_ar,
                        'government_name_en' => $provider->government_name_en,
                        // DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorites_view WHERE favorites_view.user_id = $userId AND favorites_view.provider_id = provider_id) THEN 1 ELSE 0 END) as is_favorite"),
                        'created_at' => $provider->created_at,
                        'updated_at' => $provider->updated_at,
                    ];
                })->values();

                return [
                    'country_name_ar' => $country->country_name_ar,
                    'country_name_en' => $country->country_name_en,
                    'providers' => $topProviders  // Add only the top 5 providers
                ];
            })->values();

            return response()->json([
                "status" => "success",
                "message" => "Data fetched successfully",
                'data' => $formattedData
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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

    public function countryTopProviders(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'nullable|exists:users,id',
            ]);

            $userId = $request->user_id;
            $providers = DB::table('provider_details')
                ->select(
                    'provider_details.*',
                    DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorites_view WHERE favorites_view.user_id = $userId AND favorites_view.provider_id = provider_details.provider_id) THEN 1 ELSE 0 END) as is_favorite")
                )
                ->where('country_id', $id)
                ->orderByDesc('rating')
                ->limit(5)
                ->get();

            return response()->json([
                "status" => "success",
                "message" => "Data fetched successfully",
                "data" => $providers,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
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
