<?php

namespace App\Http\Requests\Admin\Iosbenfit;
use App\Http\Requests\BaseRequest\BaseRequest;
class IosbenfitUpdateRequest extends BaseRequest
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
        ];
    }
}
