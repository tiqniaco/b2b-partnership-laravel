<?php

namespace App\Http\Resources\Admin\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'months_plan_id' => $this->months_plan_id,
            'months_plan_name' => $this->monthsPlan?->duration_months,
            'service_count' => $this->service_count,
            'product_count' => $this->product_count,
            'is_trial' => $this->is_trial,
            'trial_days' => $this->trial_days,
            'is_active' => $this->is_active,
            'is_popular' => $this->is_popular,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
