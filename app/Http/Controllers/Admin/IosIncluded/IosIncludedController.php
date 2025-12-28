<?php

namespace App\Http\Controllers\Admin\IosIncluded;

use App\Repositories\IosIncluded\IosIncludedRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\IosIncluded\IosIncludedStoreRequest;
use App\Http\Requests\Admin\IosIncluded\IosIncludedUpdateRequest;
use App\Http\Resources\Admin\IosIncluded\IosIncludedResource;

class IosIncludedController extends BaseController
{
    public function __construct(IosIncludedRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'IosIncluded'
        );

        $this->storeRequestClass = IosIncludedStoreRequest::class;
        $this->updateRequestClass = IosIncludedUpdateRequest::class;
        $this->resourceClass = IosIncludedResource::class;
    }
}
