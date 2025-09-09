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
                'agent_id' => 'sometimes|exists:users,id',
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'address' => 'sometimes|string',
                'city_id' => 'sometimes|exists:cities,id',
                'area_id' => 'sometimes|exists:areas,id',
                'price' => 'sometimes|numeric|min:0',
                'images' => 'sometimes|array',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'features' => 'sometimes|array',
                'features.*.key' => 'sometimes|string',
                'features.*.value' => 'sometimes|string',
            ];
        }

        return [
            'property_type_id' => 'required|exists:property_types,id',
            'agent_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'sometimes|string',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'price' => 'required|numeric|min:0',
            'images' => 'sometimes|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'city_id.required' => 'المدينة مطلوبة',
            'city_id.exists' => 'المدينة المحددة غير موجودة',
            'area_id.required' => 'المنطقة مطلوبة',
            'area_id.exists' => 'المنطقة المحددة غير موجودة',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من أو يساوي صفر',
            'status.in' => 'حالة العقار يجب أن تكون: متاح، مؤجر، أو مباع',
            'is_active.boolean' => 'حالة النشاط يجب أن تكون صحيح أو خطأ',
            'marketer_id.exists' => 'المسوق المحدد غير موجود',
        ];
    }
}
