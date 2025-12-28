<?php

namespace App\Http\Requests\Admin\Package;

use App\Http\Requests\BaseRequest\BaseRequest;

class PackageStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'months_plan_id' => 'required|integer|exists:months_plans,id',
            'service_count' => 'nullable|integer',
            'product_count' => 'required|integer',
            'is_trial' => 'nullable|boolean',
            'trial_days' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'is_popular' => 'nullable|boolean',
        ];
    }
}
