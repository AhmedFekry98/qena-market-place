<?php

namespace App\Features\Properties\Requests;

use App\Abstracts\BaseFormRequest;

class PropertyRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        if($this->method() === 'put') {
            return [
                'property_type_id' => 'sometimes|exists:property_types,id',
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'address' => 'sometimes|string',
                'city' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric|min:0',
                'area' => 'sometimes|numeric|min:0',
                'status' => 'sometimes|in:available,rented,sold',
                'features' => 'sometimes|array',
                'features.*.key' => 'sometimes|string',
                'features.*.value' => 'sometimes|string',
            ];
        }

        return [
            'property_type_id' => 'required|exists:property_types,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'area' => 'required|numeric|min:0',
            'features' => 'sometimes|array',
            'features.*.key' => 'required_with:features|string',
            'features.*.value' => 'required_with:features|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'property_type_id.required' => 'نوع العقار مطلوب',
            'property_type_id.exists' => 'نوع العقار المحدد غير موجود',
            'title.required' => 'عنوان العقار مطلوب',
            'title.max' => 'عنوان العقار يجب أن يكون أقل من 255 حرف',
            'description.required' => 'وصف العقار مطلوب',
            'address.required' => 'عنوان العقار مطلوب',
            'city.required' => 'المدينة مطلوبة',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي صفر',
            'area.required' => 'المساحة مطلوبة',
            'area.numeric' => 'المساحة يجب أن تكون رقم',
            'area.min' => 'المساحة يجب أن تكون أكبر من صفر',
            'status.in' => 'حالة العقار يجب أن تكون: متاح، مؤجر، أو مباع',
        ];
    }
}
