<?php

namespace App\Repositories\Package;

use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\Package;

class PackageRepository extends BaseRepository implements PackageRepositoryInterface
{
    public function __construct(Package $model)
    {
        parent::__construct($model);
    }
}
