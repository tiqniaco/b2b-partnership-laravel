<?php

namespace App\Http\Controllers\Admin\Iosbenfit;

use App\Repositories\Iosbenfit\IosbenfitRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\Iosbenfit\IosbenfitStoreRequest;
use App\Http\Requests\Admin\Iosbenfit\IosbenfitUpdateRequest;
use App\Http\Resources\Admin\Iosbenfit\IosbenfitResource;

class IosbenfitController extends BaseController
{
    public function __construct(IosbenfitRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'Iosbenfit'
        );

        $this->storeRequestClass = IosbenfitStoreRequest::class;
        $this->updateRequestClass = IosbenfitUpdateRequest::class;
        $this->resourceClass = IosbenfitResource::class;
    }
}
