<?php

namespace App\Services;

use \App\Repositories\Package\PackageRepositoryInterface;
use \App\Repositories\UserPackage\UserPackageRepositoryInterface;
use App\Traits\ApiResponseTrait;

class UserSubscripeService
{
    use ApiResponseTrait;

    public function __construct(public PackageRepositoryInterface $packageRepository, public UserPackageRepositoryInterface $userPackageRepository) {}
    public function subscripe($data, $userId)
    {
        $pakage = $this->packageRepository->find($data['package_id']);

        // i want check is have is tire check the package id have option is tire = true and check the user id  have is tire = true
        if (!empty($data['is_trial'])) {
            $userPackage = $this->userPackageRepository->hasTrialPackage($userId);
            if ($userPackage) {
                return $this->errorResponse('User already has a trial package.', 400);
            }
            $endDate = now()->addDays($pakage->trial_duration_days);
            $data['is_trial'] = true;
        } else {
            $endDate = now()->addDays($pakage->monthsPlan->duration_months * 30);
            $data['is_trial'] = false;
        }



        $data = [
            'user_id' => $userId,
            'package_id' => $data['package_id'],
            'start_date' => now(),
            'end_date' => $endDate,
            'status' => 'active',
            'price' => $pakage->price,
            'is_trial' => $data['is_trial'],
        ];
        $data = $this->userPackageRepository->create($data);
        // i want log the user id 
        return $this->successResponse($data, 'User subscribed to package successfully.', 201);
    }
}
