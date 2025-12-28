<?php

namespace App\Http\Requests\Admin\Iosbenfit;
use App\Http\Requests\BaseRequest\BaseRequest;
class IosbenfitStoreRequest extends BaseRequest
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
        ];
    }
}
