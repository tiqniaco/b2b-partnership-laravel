<?php

namespace App\Repositories\UserPackage;

use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Repositories\BaseRepository\BaseRepository;
use App\Models\UserPackages;

class UserPackageRepository extends BaseRepository implements UserPackageRepositoryInterface
{
    public function __construct(UserPackages $model)
    {
        parent::__construct($model);
    }

    public function hasTrialPackage($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('is_trial', true)
            ->first();
    }
}
