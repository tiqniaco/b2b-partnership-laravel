<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Complaint;
use App\Models\RequestService;
use App\Models\StoreOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clients = DB::table('client_details_view')
                ->paginate(12);

            return response()->json($clients, 200);
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
            $client = DB::table('client_details_view')
                ->where('client_id', $id)
                ->first();

            $jobsCount = 0;
            $shoppingCount = StoreOrder::where('user_id', $client->user_id)->count();
            $servicesCount = RequestService::where('client_id', $id)->count();
            $complaintsCount = Complaint::where('user_id', $client->user_id)->count();


            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'jobsCount' => $jobsCount,
                    'shoppingCount' => $shoppingCount,
                    'servicesCount' => $servicesCount,
                    'complaintsCount' => $complaintsCount,
                    'data' => $client,
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
            $request->validate([
                "name" => "nullable|string",
                "email" => "nullable|email",
                "country_code" => "nullable|string|max:3",
                "phone" => "nullable|string",
                "government_id" => "nullable|exists:governments,id",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg",
            ]);

            $client = Client::findOrFail($id);
            $user = User::findOrFail($client->user_id);

            if ($request->hasFile('image')) {
                if (file_exists(public_path($user->image))) {
                    unlink(public_path($user->image));
                }
                $imageName = 'images/clients/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/clients'), $imageName);
                $user->image = $imageName;
            }

            $user->name = $request->name ?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->phone = $request->phone ?? $user->phone;
            $user->country_code = $request->country_code ?? $user->country_code;
            $client->governments_id = $request->government_id ?? $client->governments_id;

            $user->save();
            $client->save();

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
            $client = Client::findOrFail($id);
            $user = User::findOrFail($client->user_id);

            $client->delete();
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

    public function services(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,confirmed,canceled',
            ]);

            if ($request->status == null) {
                $requestServices = DB::table('request_service_details_view')
                    ->where('client_id', $id)
                    ->paginate(12);
            } else {
                $requestServices = DB::table('request_service_details_view')
                    ->where('client_id', $id)
                    ->where('status', $request->status)
                    ->paginate(12);
            }

            return response()->json($requestServices, 200);
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
