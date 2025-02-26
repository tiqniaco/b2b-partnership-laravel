<?php

namespace App\Http\Controllers;

use App\Models\ProviderService;
use App\Models\ProviderServiceFeature;
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

            $providerServices = DB::table('provider_service_details')
                //         ->select(
                //             'provider_service_details.*',  // Select all columns from provider_service_details
                //             DB::raw("
                //     COALESCE(
                //         (SELECT 1 FROM favorites_view 
                //          WHERE favorites_view.user_id = ? 
                //            AND favorites_view.provider_id = provider_service_details.id 
                //          LIMIT 1), 0
                //     ) AS is_favorite
                // ")
                //         )
                // ->addBinding($userId, 'select')  // Add the binding for the parameter
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
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'price' => 'nullable|numeric',
                'overview' => 'required|string',
                'video' => 'nullable|string|max:255',
                'features_ar' => 'required|array',
                'features_en' => 'required|array',
                'features_ar.*' => 'required|string|max:255',
                'features_en.*' => 'required|string|max:255',
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

            foreach ($request->features_ar as $index => $feature_ar) {
                $feature = new ProviderServiceFeature();
                $feature->provider_service_id = $providerService->id;
                $feature->feature_ar = $feature_ar;
                $feature->feature_en = $request->features_en[$index];
                $feature->save();
            }


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

            $providerService = DB::table('provider_service_details')
                //         ->select(
                //             '*',
                //             DB::raw("
                //     COALESCE(
                //         (SELECT 1 FROM favorites_view 
                //          WHERE favorites_view.user_id = ? 
                //            AND favorites_view.provider_id = provider_service_details.id 
                //          LIMIT 1), 0
                //     ) AS is_favorite
                // ")
                //         )
                //         ->addBinding($userId, 'select')  // Add the binding for the parameter
                ->where('id', $id)
                ->first();

            $provider =
                DB::table('provider_details')
                ->where('provider_id', $providerService->provider_id)
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
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'price' => 'nullable|numeric',
                'overview' => 'nullable|string',
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
                    'message' => 'Data updated successfully.',
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

    public function specializationsServices($id)
    {
        try {

            $userId =  Auth::user()->id;

            $providerServices = DB::table('provider_service_details')
                //         ->select(
                //             '*',
                //             DB::raw("
                //     COALESCE(
                //         (SELECT 1 FROM favorites_view 
                //          WHERE favorites_view.user_id = ? 
                //            AND favorites_view.provider_id = provider_service_details.id 
                //          LIMIT 1), 0
                //     ) AS is_favorite
                // ")
                //         )
                //         ->addBinding($userId, 'select')  // Add the binding for the parameter
                ->where('sub_specialization_id', '=', $id)
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
}