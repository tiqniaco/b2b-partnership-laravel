<?php

namespace App\Http\Controllers\Admin\MonthsPlan;

use App\Repositories\MonthsPlan\MonthsPlanRepositoryInterface;
use App\Http\Controllers\BaseController\BaseController;
use App\Http\Requests\Admin\MonthsPlan\MonthsPlanStoreRequest;
use App\Http\Requests\Admin\MonthsPlan\MonthsPlanUpdateRequest;
use App\Http\Resources\Admin\MonthsPlan\MonthsPlanResource;

class MonthsPlanController extends BaseController
{
    public function __construct(MonthsPlanRepositoryInterface $repository)
    {
        parent::__construct();

        $this->initService(
            repository: $repository,
            collectionName: 'MonthsPlan'
        );

        $this->storeRequestClass = MonthsPlanStoreRequest::class;
        $this->updateRequestClass = MonthsPlanUpdateRequest::class;
        $this->resourceClass = MonthsPlanResource::class;
    }
}
