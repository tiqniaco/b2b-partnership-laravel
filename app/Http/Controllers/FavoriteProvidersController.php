<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteProvidersController extends Controller
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

            $favoriteProviders = DB::table('favorites_view')
                ->where('user_id', $request->user_id)
                ->get();

            foreach ($favoriteProviders as $favoriteProvider) {
                $favoriteProvider->is_favorite = "1";
            }

            if ($favoriteProviders->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No data found.',
                    'data' => $favoriteProviders
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $favoriteProviders
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
                "provider_id" => "required|exists:providers,id",
            ]);

            $check = FavoriteProvider::where('user_id', $request->user_id)
                ->where('provider_id', $request->provider_id)
                ->first();

            if ($check) {
                $check->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Provider removed from favorites successfully.',
                ], 200);
            }

            $favoriteService = new FavoriteProvider();
            $favoriteService->user_id = $request->user_id;
            $favoriteService->provider_id = $request->provider_id;
            $favoriteService->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Provider added to favorites successfully.',
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
