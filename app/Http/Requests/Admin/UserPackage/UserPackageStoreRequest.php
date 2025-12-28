<?php

namespace App\Http\Requests\Admin\UserPackage;

use App\Http\Requests\BaseRequest\BaseRequest;

class UserPackageStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'package_id' => 'required|integer|exists:packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,expired,canceled,pending',
            'payment_method' => 'nullable|in:credit_card,paypal,bank_transfer',
            'is_trial' => 'required|integer',
        ];
    }
}
