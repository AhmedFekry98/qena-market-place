<?php

namespace App\Features\Properties\Requests;

use App\Abstracts\BaseFormRequest;

class PropertyTransactionRequest extends BaseFormRequest
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
        return [
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|in:rent,sale',
            'start_date' => 'required_if:type,rent|date|after_or_equal:today',
            'end_date' => 'required_if:type,rent|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'property_id.required' => 'العقار مطلوب',
            'property_id.exists' => 'العقار المحدد غير موجود',
            'type.required' => 'نوع العملية مطلوب',
            'type.in' => 'نوع العملية يجب أن يكون إيجار أو بيع',
            'start_date.required_if' => 'تاريخ البداية مطلوب للإيجار',
            'start_date.date' => 'تاريخ البداية يجب أن يكون تاريخ صحيح',
            'start_date.after_or_equal' => 'تاريخ البداية يجب أن يكون اليوم أو بعده',
            'end_date.required_if' => 'تاريخ النهاية مطلوب للإيجار',
            'end_date.date' => 'تاريخ النهاية يجب أن يكون تاريخ صحيح',
            'end_date.after' => 'تاريخ النهاية يجب أن يكون بعد تاريخ البداية',
            'total_price.required' => 'السعر الإجمالي مطلوب',
            'total_price.numeric' => 'السعر الإجمالي يجب أن يكون رقم',
            'total_price.min' => 'السعر الإجمالي يجب أن يكون أكبر من أو يساوي صفر',
        ];
    }
}
