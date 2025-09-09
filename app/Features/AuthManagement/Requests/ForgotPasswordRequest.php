<?php

namespace App\Features\AuthManagement\Requests;

use App\Abstracts\BaseFormRequest;
use App\Traits\HandlesFailedValidation;

class ForgotPasswordRequest extends BaseFormRequest
{
    use HandlesFailedValidation;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "phone_code" => ['required', 'numeric', 'digits_between:2,5'],
            'phone' => ['required', 'numeric', 'digits_between:9,15'],
        ];
    }
}
