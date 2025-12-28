<?php

namespace App\Repositories\Iosbenfit;

use App\Repositories\Iosbenfit\IosbenfitRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Iosbenfit;

class IosbenfitRepository extends BaseRepository implements IosbenfitRepositoryInterface
{
    public function __construct(Iosbenfit $model)
    {
        parent::__construct($model);
    }
}
