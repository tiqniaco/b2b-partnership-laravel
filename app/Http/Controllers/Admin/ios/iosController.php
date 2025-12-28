<?php

namespace App\Http\Controllers\Admin\ios;

use App\Repositories\ios\iosRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\ios\iosStoreRequest;
use App\Http\Requests\Admin\ios\iosUpdateRequest;
use App\Http\Resources\Admin\ios\iosResource;

class iosController extends BaseController
{
    public function __construct(iosRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'ios'
        );

        $this->storeRequestClass = iosStoreRequest::class;
        $this->updateRequestClass = iosUpdateRequest::class;
        $this->resourceClass = iosResource::class;
    }
}
