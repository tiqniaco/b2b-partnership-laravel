<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProviderServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $userId =  Auth::user()->id;

            $providerServices = ProviderService::select(
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
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'address' => 'nullable|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'price' => 'required|numeric',
                'overview' => 'required|string|max:255',
                'video' => 'nullable|string|max:255',
            ]);

            $providerService = new ProviderService();
            $providerService->provider_id = $request->provider_id;
            $providerService->governments_id = $request->governments_id;
            $providerService->sub_specialization_id = $request->sub_specialization_id;
            $providerService->name_ar = $request->name_ar;
            $providerService->name_en = $request->name_en;
            $providerService->address = $request->address;
            $providerService->description = $request->description;
            $providerService->price = $request->price;
            $providerService->overview = $request->overview;
            $providerService->video = $request->video;
            if ($request->hasFile('image')) {
                $imageName = 'images/provider_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/provider_services'), $imageName);
                $providerService->image = $imageName;
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
            $userId =  Auth::user()->id;

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
                ->where('provider_services.id', $id)
                ->first();

            $provider = Provider::select(
                'users.id as user_id',
                'users.name as name',
                'users.email as email',
                'users.country_code as country_code',
                'users.phone as phone',
                'users.image as image',
                'providers.id as provider_id',
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
                ->where('providers.id', $providerService->provider_id)
                ->first();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $providerService,
                    'provider' => $provider,
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
                'name_ar' => 'nullable|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'price' => 'nullable|numeric',
                'overview' => 'nullable|string|max:255',
                'video' => 'nullable|string|max:255',
            ]);

            $providerService = ProviderService::findOrFail($id);
            $providerService->name_ar = $request->name_ar ?? $providerService->name_ar;
            $providerService->name_en = $request->name_en ?? $providerService->name_en;
            $providerService->address = $request->address ?? $providerService->address;
            $providerService->description = $request->description ?? $providerService->description;
            $providerService->price = $request->price ?? $providerService->price;
            $providerService->overview = $request->overview ?? $providerService->overview;
            $providerService->video = $request->video ?? $providerService->video;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($providerService->image))) {
                    unlink(public_path($providerService->image));
                }
                $imageName = 'images/provider_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/provider_services'), $imageName);
                $providerService->image = $imageName;
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