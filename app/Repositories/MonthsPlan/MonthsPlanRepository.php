<?php

namespace App\Repositories\MonthsPlan;

use App\Repositories\MonthsPlan\MonthsPlanRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\MonthsPlan;

class MonthsPlanRepository extends BaseRepository implements MonthsPlanRepositoryInterface
{
    public function __construct(MonthsPlan $model)
    {
        parent::__construct($model);
    }
}
