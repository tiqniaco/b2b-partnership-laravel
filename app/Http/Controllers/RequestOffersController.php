<?php

namespace App\Http\Controllers;

use App\Models\RequestOffer;
use App\Models\RequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'request_service_id' => 'required|exists:request_services,id',
            ]);
            $offers = DB::table('request_offers_details_view')
                ->where('request_service_id', $request->request_service_id)
                ->whereIn('request_offer_status', ['accepted', 'pending'])
                ->orderBy('request_offer_created_at', 'desc')
                ->paginate(12);

            return response()->json(
                $offers,
                200
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
            if (Auth::user()->role == 'client') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not allowed to create a offer for a service.',
                ], 403);
            }

            $request->validate([
                'provider_id' => 'required|exists:providers,id',
                'request_service_id' => 'required|exists:request_services,id',
                'offer_description' => 'required|string',
                'price' => 'required|numeric',
            ]);

            $requestOffer = new RequestOffer();
            $requestOffer->provider_id = $request->provider_id;
            $requestOffer->request_service_id = $request->request_service_id;
            $requestOffer->offer_description = $request->offer_description;
            $requestOffer->price = $request->price;
            $requestOffer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
            ], 201);
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
            $offers = DB::table('request_offers_details_view')
                ->where('request_offer_id', $id)
                ->first();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $offers
                ],
                200
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
            if (Auth::user()->role == 'client') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not allowed to create a offer for a service.',
                ], 403);
            }

            $request->validate([
                'provider_id' => 'nullable|exists:providers,id',
                'request_service_id' => 'nullable|exists:request_services,id',
                'offer_description' => 'nullable|string',
                'price' => 'nullable|numeric',
            ]);

            $requestOffer = RequestOffer::findOrFail($id);
            $requestOffer->provider_id = $request->provider_id ?? $requestOffer->provider_id;
            $requestOffer->request_service_id = $request->request_service_id ?? $requestOffer->request_service_id;
            $requestOffer->offer_description = $request->offer_description ?? $requestOffer->offer_description;
            $requestOffer->price = $request->price ?? $requestOffer->price;
            $requestOffer->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
            ], 201);
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
            if (Auth::user()->role == 'client') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not allowed to create a offer for a service.',
                ], 403);
            }


            $requestOffer = RequestOffer::findOrFail($id);

            $requestOffer->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
            ], 201);
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

    public function acceptOffer($id)
    {
        try {
            if (Auth::user()->role == 'provider') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not allowed to create a offer for a service.',
                ], 403);
            }

            // $request->validate([
            //     'status' => 'required|in:accepted,rejected,completed',
            // ]);

            $requestOffer = RequestOffer::findOrFail($id);

            $requestOffer->status = "accepted";
            $requestOffer->save();

            RequestOffer::where('request_service_id', $requestOffer->request_service_id)
                ->where('id', '!=', $id)
                ->get()
                ->each(function ($item) {
                    $item->status = "rejected";
                    $item->save();
                });


            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
            ], 201);
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
