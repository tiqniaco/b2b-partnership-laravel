<?php

namespace App\Http\Requests\Admin\Package;

use App\Http\Requests\BaseRequest\BaseRequest;

class PackageUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|sometimes|string',
            'price' => 'sometimes|required|numeric',
            'months_plan_id' => 'sometimes|required|integer|exists:months_plans,id',
            'service_count' => 'sometimes|required|integer',
            'product_count' => 'sometimes|required|integer',
            'is_trial' => 'sometimes|required|integer',
            'trial_days' => 'sometimes|required|integer',
            'is_active' => 'sometimes|required|integer',
            'is_popular' => 'nullable|boolean',

        ];
    }
}
