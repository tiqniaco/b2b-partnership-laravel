<?php

namespace App\Http\Controllers;

use App\Models\RequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RequestServicesController extends Controller
{
    public $notification;

    public function __construct()
    {
        $this->notification = new NotificationController();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'specialization_id' => 'nullable|exists:specializations,id',
                'sub_specialization_id' => 'nullable|exists:sub_specializations,id',
                'country_id' => 'nullable|exists:countries,id',
                'government_id' => 'nullable|exists:governments,id',
                'search' => 'nullable|string',
            ]);

            $requestServices = DB::table('request_service_details_view')
                ->where('status', '<>', 'Canceled')
                ->when($request->filled('specialization_id'), function ($query) use ($request) {
                    return $query->where('specialization_id', $request->specialization_id);
                })
                ->when($request->filled('sub_specialization_id'), function ($query) use ($request) {
                    return $query->where('sub_specialization_id', $request->sub_specialization_id);
                })
                ->when($request->filled('country_id'), function ($query) use ($request) {
                    return $query->where('country_id', $request->country_id);
                })
                ->when($request->filled('government_id'), function ($query) use ($request) {
                    return $query->where('government_id', $request->government_id);
                })
                ->when($request->filled('search'), function ($query) use ($request) {
                    return $query->where('title_ar', 'like', '%' . $request->search . '%')
                        ->orWhere('title_en', 'like', '%' . $request->search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(12);


            return response()->json(
                $requestServices,
                200
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
//            if (Auth::user()->role == 'provider') {
//                return response()->json([
//                    'status' => 'error',
//                    'message' => 'You are not allowed to create a request service.',
//                ], 403);
//            }

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'governments_id' => 'required|exists:governments,id',
                'sub_specialization_id' => 'required|exists:sub_specializations,id',
                'title_ar' => 'required|string|max:255',
                'title_en' => 'required|string|max:255',
                'address' => 'required|string',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            ]);

            $requestService = new RequestService();
            $requestService->user_id = $request->user_id;
            $requestService->governments_id = $request->governments_id;
            $requestService->sub_specialization_id = $request->sub_specialization_id;
            $requestService->title_ar = $request->title_ar;
            $requestService->title_en = $request->title_en;
            $requestService->address = $request->address;
            $requestService->description = $request->description;
            if ($request->hasFile('image')) {
                $imageName = 'images/request_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/request_services'), $imageName);
                $requestService->image = $imageName;
            }
            $requestService->save();

            $this->notification->sendNotification(
                topic: "all",
                title: "New Client Service",
                body: "New service request from client with title: " . $requestService->title_en,
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
            ], 201);
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $requestService = DB::table('request_service_details_view')
                ->where('id', $id)
                ->first();

            if (!$requestService) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not found.',
                ], 404);
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $requestService
                ],
                200
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'user_id' => 'nullable|exists:users,id',
                'governments_id' => 'nullable|exists:governments,id',
                'sub_specialization_id' => 'nullable|exists:sub_specializations,id',
                'title_ar' => 'nullable|string|max:255',
                'title_en' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'status' => 'nullable|in:Pending,Closed,Canceled',
            ]);

            $requestService = RequestService::findOrFail($id);
            $requestService->user_id = $request->user_id ?? $requestService->user_id;
            $requestService->governments_id = $request->governments_id ?? $requestService->governments_id;
            $requestService->sub_specialization_id = $request->sub_specialization_id ?? $requestService->sub_specialization_id;
            $requestService->title_ar = $request->title_ar ?? $requestService->title_ar;
            $requestService->title_en = $request->title_en ?? $requestService->title_en;
            $requestService->address = $request->address ?? $requestService->address;
            $requestService->description = $request->description ?? $requestService->description;
            $requestService->status = $request->status ?? $requestService->status;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($requestService->image))) {
                    unlink(public_path($requestService->image));
                }
                $imageName = 'images/request_services/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/request_services'), $imageName);
                $requestService->image = $imageName;
            }
            $requestService->save();

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
            $requestService = RequestService::findOrFail($id);
            if (file_exists(public_path($requestService->image))) {
                unlink(public_path($requestService->image));
            }
            $requestService->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
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
