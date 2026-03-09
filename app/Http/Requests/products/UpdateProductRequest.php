<?php

namespace App\Http\Requests\products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $productId = $this->id; // من الـ hidden input
        $rules = [
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'max_order' => 'nullable|integer|min:1',
            'product_categories' => 'required|string',
        ];

        foreach ($this->translations ?? [] as $langCode => $data) {
            $rules["translations.{$langCode}.title"] = [
                'required',
                'string',
                Rule::unique('product_translations', 'title')
                    ->where('lang_id', $langCode)
                    ->ignore($this->getTranslationId($langCode, $productId)),
            ];
            $rules["translations.{$langCode}.description"] = 'required|string';
        }

        // الصورة: ليست إلزامية في التعديل (يمكن الاحتفاظ بالقديمة)
        $rules['primary_image'] = 'nullable|mimes:jpeg,png,jpg,gif,webp';
        $rules['cropped_image'] = 'nullable|string';

        return $rules;
    }

    /**
     * مساعدة للحصول على ID الترجمة الحالية لتخطيها في unique
     */
    private function getTranslationId($langCode, $productId)
    {
        $trans = \App\Models\ProductTranslation::where('product_id', $productId)
            ->where('lang_id', $langCode)
            ->first();

        return $trans?->id ?? 0;
    }

    public function messages()
    {
        return [
            'translations.*.title.required' => __('dashboard.Title_required'),
            'translations.*.title.unique' => __('dashboard.Duplicate Title'),
            'translations.*.description.required' => __('dashboard.Description_required'),
        ];
    }
}
