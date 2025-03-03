<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Provider;
use App\Models\ProviderService;
use App\Models\StoreOrder;
use App\Models\StoreProduct;
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
            $userId = Auth::user()->id;
            $providers = DB::table('provider_details')
                ->select(
                    'provider_details.*',
                    DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorites_view WHERE favorites_view.user_id = $userId AND favorites_view.provider_id = provider_details.provider_id) THEN 1 ELSE 0 END) as is_favorite"),
                )
                ->paginate(12);

            return response()->json($providers, 200);
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
            $userId = Auth::user()->id;
            $provider = DB::table('provider_details')
                ->select(
                    'provider_details.*',
                    DB::raw("(CASE WHEN EXISTS (SELECT 1 FROM favorites_view WHERE favorites_view.user_id = $userId AND favorites_view.provider_id = provider_details.provider_id) THEN 1 ELSE 0 END) as is_favorite"),
                )
                ->where('provider_id', $id)
                ->first();

            $jobsCount = 0;
            $shoppingCount = StoreProduct::count();
            $ordersCount = StoreOrder::where('user_id', $provider->user_id)->count();
            $complaintsCount = Complaint::where('user_id', $provider->user_id)->count();



            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'jobsCount' => $jobsCount,
                'shoppingCount' => $shoppingCount,
                'ordersCount' => $ordersCount,
                'complaintsCount' => $complaintsCount,
                'data' => $provider,
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                "name" => "nullable|string",
                "email" => "nullable|email",
                "country_code" => "nullable|string|max:3",
                "phone" => "nullable|string",
                "government_id" => "nullable|exists:governments,id",
                "sub_specialization_id" => "nullable|exists:sub_specializations,id",
                "provider_types_id" => "nullable|exists:provider_types,id",
                "bio" => "nullable|string",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
                "commercial_register" => "nullable|mimes:pdf",
                "tax_card" => "nullable|mimes:pdf",
            ]);

            $provider = Provider::findOrFail($id);
            $user = User::findOrFail($provider->user_id);

            if ($request->hasFile('image')) {
                if (file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $imageName = 'images/providers/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/providers'), $imageName);
                $user->image = $imageName;
            }

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->country_code = $request->country_code ?? $user->country_code;

            $provider->bio = $request->bio ?? $provider->bio;
            $provider->governments_id = $request->government_id ?? $provider->governments_id;
            $provider->sub_specialization_id = $request->sub_specialization_id ?? $provider->sub_specialization_id;
            $provider->provider_types_id = $request->provider_types_id ?? $provider->provider_types_id;
            if ($request->hasFile('commercial_register')) {
                if (file_exists(public_path($provider->commercial_register))) {
                    unlink(public_path($provider->commercial_register));
                }
                $imageName = 'images/providers/' . time() . '.' . $request->commercial_register->extension();
                $request->commercial_register->move(public_path('images/providers'), $imageName);
                $provider->commercial_register = $imageName;
            }

            if ($request->hasFile('tax_card')) {
                if (file_exists(public_path($provider->tax_card))) {
                    unlink(public_path($provider->tax_card));
                }
                $imageName = 'images/providers/' . time() . '.' . $request->tax_card->extension();
                $request->tax_card->move(public_path('images/providers'), $imageName);
                $provider->tax_card = $imageName;
            }
            $user->save();
            $provider->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
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
            $providerServices = DB::table('provider_service_details')
                ->where('provider_id', '=', $id)
                ->get();


            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $providerServices,
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
