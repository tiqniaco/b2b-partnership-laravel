<?php

namespace App\Http\Resources\Admin\Iosbenfit;

use Illuminate\Http\Resources\Json\JsonResource;

class IosbenfitResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'ios_id' => $this->ios_id,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
