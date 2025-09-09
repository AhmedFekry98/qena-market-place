<?php

namespace App\Features\AuthManagement\Requests;

use App\Abstracts\BaseFormRequest;
use App\Traits\HandlesFailedValidation;

class LoginRequest extends BaseFormRequest
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

        $guard = request()->guard;

        if($guard != "customer"){
            $rules['password'] = [
                'required',
                'string',
                'max:30' ,
                'min:8',
            ];
        }

        $rules['phone_code'] = ['required', 'numeric','digits_between:2,5'];
        $rules['phone'] = ['required', 'numeric', 'digits_between:3,15', 'regex:/^[1-9]/'];

        return $rules;
    }
}
