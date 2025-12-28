<?php

namespace App\Http\Requests\Admin\MonthsPlan;
use App\Http\Requests\BaseRequest\BaseRequest;
class MonthsPlanUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'duration_months' => 'sometimes|required|integer',
        ];
    }
}
