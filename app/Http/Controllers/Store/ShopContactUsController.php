<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ShopContactUs;
use Illuminate\Http\Request;

class ShopContactUsController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $contactUs = ShopContactUs::find(1);
        if (!$contactUs) {
            return response()->json([
                'message' => 'Contact Us information not found.'
            ], 404);
        }

        return response()->json($contactUs, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'whatsapp' => 'required|string|max:255',
        ]);

        $contactUs = ShopContactUs::find(1);
        if (!$contactUs) {
            $contactUs = new ShopContactUs();
        }
        $contactUs->whatsapp = $request->whatsapp;
        $contactUs->save();

        return response()->json([
            'message' => 'Contact Us information saved successfully.'
        ], 201);
    }

}
