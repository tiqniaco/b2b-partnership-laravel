<?php

namespace App\Http\Requests\Admin\IosIncluded;
use App\Http\Requests\BaseRequest\BaseRequest;
class IosIncludedStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ios_id' => 'required|integer|exists:ios,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
