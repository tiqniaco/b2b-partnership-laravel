<?php

namespace App\Repositories\ios;

use App\Repositories\ios\iosRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\ios;

class iosRepository extends BaseRepository implements iosRepositoryInterface
{
    public function __construct(ios $model)
    {
        parent::__construct($model);
    }
}
