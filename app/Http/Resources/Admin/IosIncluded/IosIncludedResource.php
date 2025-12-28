<?php

namespace App\Http\Resources\Admin\IosIncluded;

use Illuminate\Http\Resources\Json\JsonResource;

class IosIncludedResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'ios_id' => $this->ios_id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
