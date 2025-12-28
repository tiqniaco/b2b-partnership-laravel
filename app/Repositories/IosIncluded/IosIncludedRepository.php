<?php

namespace App\Repositories\IosIncluded;

use App\Repositories\IosIncluded\IosIncludedRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\IosIncluded;

class IosIncludedRepository extends BaseRepository implements IosIncludedRepositoryInterface
{
    public function __construct(IosIncluded $model)
    {
        parent::__construct($model);
    }
}
