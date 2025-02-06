<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderReview;
use Illuminate\Http\Request;

class ProviderReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'provider_id' => 'required|exists:provider_services,id',
            ]);

            $reviews = ProviderReview::select(
                'provider_reviews.id',
                'provider_reviews.review',
                'provider_reviews.rating',
                'users.name',
                'users.email',
                'users.image',
                'users.id as user_id',
                'provider_reviews.created_at',
            )
                ->join('users', 'provider_reviews.user_id', "=", "users.id")
                ->where('provider_reviews.provider_id', "=", $request->provider_id)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $reviews
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
                'provider_id' => 'required|exists:providers,id',
                'user_id' => 'required|exists:users,id',
                'review' => 'required|string',
                'rating' => 'required|integer',
            ]);

            $review = new ProviderReview();
            $review->provider_id = $request->provider_id;
            $review->user_id = $request->user_id;
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();

            $allReviews = ProviderReview::where('provider_id', $request->provider_id)
                ->get();

            $rating = 0;
            foreach ($allReviews as $review) {
                $rating += $review->rating;
            }

            $provider = Provider::findOrFail($request->provider_id);
            $provider->rating = $rating / $allReviews->count();
            $provider->save();

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
            $review = ProviderReview::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $review
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
        try {
            $request->validate([
                'review' => 'nullable|string',
                'rating' => 'nullable|integer',
            ]);

            $review = ProviderReview::findOrFail($id);

            $provider = Provider::findOrFail($review->provider_id);

            $review->review = $request->review ?? $review->review;
            $review->rating = $request->rating ?? $review->rating;
            $review->save();

            $allReviews = ProviderReview::where('provider_id', $request->provider_id)
                ->get();

            $rating = 0;
            foreach ($allReviews as $review) {
                $rating += $review->rating;
            }

            $provider->rating = $rating / $allReviews->count();
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
            $review = ProviderReview::findOrFail($id);
            $provider = Provider::findOrFail($review->provider_id);
            $review->delete();

            $allReviews = ProviderReview::where('provider_id', $provider->id)
                ->get();

            $rating = 0;
            foreach ($allReviews as $review) {
                $rating += $review->rating;
            }

            $provider->rating = $rating / $allReviews->count();
            $provider->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
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