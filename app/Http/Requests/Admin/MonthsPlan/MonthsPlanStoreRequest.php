<?php

namespace App\Http\Requests\Admin\MonthsPlan;
use App\Http\Requests\BaseRequest\BaseRequest;
class MonthsPlanStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'duration_months' => 'required|integer',
        ];
    }
}
