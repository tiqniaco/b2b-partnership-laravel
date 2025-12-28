<?php

namespace App\Http\Requests\Admin\UserPackage;

use App\Http\Requests\BaseRequest\BaseRequest;

class UserPackageUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|integer|exists:users,id',
            'package_id' => 'sometimes|required|integer|exists:packages,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:active,expired,canceled,pending',
        ];
    }
}
