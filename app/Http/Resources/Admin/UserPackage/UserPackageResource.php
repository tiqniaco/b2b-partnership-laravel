<?php

namespace App\Http\Resources\Admin\UserPackage;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPackageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'package_id' => $this->package_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'price' => $this->price,
            'transaction_id' => $this->transaction_id,
            'payment_method' => $this->payment_method,
            'is_trial' => $this->is_trial,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
