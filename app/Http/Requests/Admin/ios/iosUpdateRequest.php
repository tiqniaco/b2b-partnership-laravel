<?php

namespace App\Http\Requests\Admin\ios;
use App\Http\Requests\BaseRequest\BaseRequest;
class iosUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|integer',
        ];
    }
}
