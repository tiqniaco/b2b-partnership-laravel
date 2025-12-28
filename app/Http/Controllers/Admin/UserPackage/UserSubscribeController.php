<?php

namespace App\Http\Controllers\Admin\UserPackage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserSubscrieRequest;
use App\Models\Package;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Services\UserSubscripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSubscribeController extends Controller
{
    public function __construct(public UserSubscripeService $userSubscripeService)
    {
        $this->middleware('auth:sanctum',);
    }

    /**
     * Display a listing of the resource.
     */
    public function subscribe(UserSubscrieRequest $request)
    {

        $data = $request->validated();
        return $this->userSubscripeService->subscripe($data, auth()->id());
    }
}
