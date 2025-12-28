<?php

namespace App\Http\Requests\Admin\IosIncluded;
use App\Http\Requests\BaseRequest\BaseRequest;
class IosIncludedUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ios_id' => 'sometimes|required|integer|exists:ios,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ];
    }
}
