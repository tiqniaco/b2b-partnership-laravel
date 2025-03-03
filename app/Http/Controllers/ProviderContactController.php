<?php

namespace App\Http\Controllers;

use App\Models\ProviderContact;
use Illuminate\Http\Request;

class ProviderContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $providersContact = ProviderContact::paginate(12);
            return response()->json($providersContact, 200);
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
            $request->validate([
                'provider_id' => 'required|exists:providers,id',
                'phone' => 'nullable|string|max:255',
                'email' => 'nullable|string|max:255',
                'whatsapp' => 'nullable|string|max:255',
                'telegram' => 'nullable|string|max:255',
                'instagram' => 'nullable|string|max:255',
                'facebook' => 'nullable|string|max:255',
                'linkedin' => 'nullable|string|max:255',
                'website' => 'nullable|string|max:255',
            ]);

            $contacts = ProviderContact::where('provider_id', $request->provider_id)->first();
            if ($contacts) {
                $contacts->phone = $request->phone ?? null;
                $contacts->email = $request->email ?? null;
                $contacts->whatsapp = $request->whatsapp ?? null;
                $contacts->telegram = $request->telegram ?? null;
                $contacts->instagram = $request->instagram ?? null;
                $contacts->facebook = $request->facebook ?? null;
                $contacts->linkedin = $request->linkedin ?? null;
                $contacts->website = $request->website ?? null;
                $contacts->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data updated successfully.',
                    'data' => $contacts,
                ], 201);
            }

            $providersContact = new ProviderContact();
            $providersContact->provider_id = $request->provider_id;
            $providersContact->phone = $request->phone;
            $providersContact->email = $request->email;
            $providersContact->whatsapp = $request->whatsapp;
            $providersContact->telegram = $request->telegram;
            $providersContact->instagram = $request->instagram;
            $providersContact->facebook = $request->facebook;
            $providersContact->linkedin = $request->linkedin;
            $providersContact->website = $request->website;
            $providersContact->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data created successfully.',
                'data' => $providersContact,
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contacts = ProviderContact::findOrFail($id);
            $contacts->delete();

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

    public function providerContacts(string $id)
    {
        try {
            $contacts = ProviderContact::where('provider_id', $id)->first();

            if (!$contacts) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Not found data.',
                    'data' => [
                        'id' => 0,
                        'provider_id' => '',
                        'phone' => '',
                        'email' => '',
                        'whatsapp' => '',
                        'telegram' => '',
                        'instagram' => '',
                        'facebook' => '',
                        'linkedin' => '',
                        'website' => '',
                        'created_at' => '',
                        'updated_at' => '',
                    ],
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $contacts,
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
