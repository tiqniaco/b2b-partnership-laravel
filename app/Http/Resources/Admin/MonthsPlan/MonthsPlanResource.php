<?php

namespace App\Http\Resources\Admin\MonthsPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class MonthsPlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'duration_months' => $this->duration_months,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
