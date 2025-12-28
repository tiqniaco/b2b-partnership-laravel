<?php

namespace App\Http\Requests\Admin\ios;
use App\Http\Requests\BaseRequest\BaseRequest;
class iosStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
        ];
    }
}
