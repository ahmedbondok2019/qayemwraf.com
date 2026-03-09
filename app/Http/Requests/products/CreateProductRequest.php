<?php

namespace App\Http\Requests\products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            // الحقول المشتركة (غير مرتبطة باللغة)
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'max_order' => 'nullable|integer|min:1',
            'product_categories' => 'required|string',
            'brand_id' => 'nullable|integer',
            'shipping_category' => 'nullable|integer',
            'item_code' => 'nullable|string',
            'barcode' => 'nullable|string',
            'model' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'video_link' => 'nullable|url',
            'video_file' => 'nullable|mimetypes:video/mp4|max:102400', // 100MB
            'pdf_file' => 'nullable|mimetypes:application/pdf|max:10240', // 10MB
            'product_options' => 'nullable|string',
            'related_products' => 'nullable|string',
        ];

        // التحقق من الترجمات لكل لغة
        foreach ($this->translations ?? [] as $langCode => $data) {
            $rules["translations.{$langCode}.title"] = [
                'required',
                'string',
                Rule::unique('product_translations', 'title')
                    ->where('lang_id', $langCode),
            ];

            $rules["translations.{$langCode}.description"] = 'required|string';
            $rules["translations.{$langCode}.slug"] = 'nullable|string';
            $rules["translations.{$langCode}.meta_title"] = 'nullable|string';
            $rules["translations.{$langCode}.meta_description"] = 'nullable|string';
            $rules["translations.{$langCode}.meta_keywords"] = 'nullable|string';
        }

        // التحقق من الصورة: يجب أن تكون إما من رفع ملف أو من cropper
        $rules['primary_image'] = 'required_without:cropped_image|nullable|image|mimes:jpeg,png,jpg,gif,webp,bmp|dimensions:min_width=200,min_height=200|max:5120'; // 5MB
        $rules['cropped_image'] = 'required_without:primary_image|nullable|string';

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // الرسائل العامة
            'price.required' => __('dashboard.Price is required.'),
            'price.min' => __('dashboard.Price must be at least 0.'),
            'quantity.required' => __('dashboard.Quantity is required.'),
            'quantity.min' => __('dashboard.Quantity must be at least 0.'),
            'product_categories.required' => __('dashboard.Please select at least one category.'),

            // الرسائل الخاصة بالترجمات
            'translations.*.title.required' => __('dashboard.Title is required.'),
            'translations.*.title.unique' => __('dashboard.This title is already taken for this language.'),
            'translations.*.description.required' => __('dashboard.Description is required.'),

            // رسائل الصور
            'primary_image.required_without' => __('dashboard.Please upload a primary image.'),
            'primary_image.image' => __('dashboard.The file must be an image.'),
            'primary_image.mimes' => __('dashboard.Image must be a file of type: jpeg, png, jpg, gif, webp, bmp.'),
            'primary_image.dimensions' => __('dashboard.Image dimensions must be at least 200x200 pixels.'),
            'primary_image.max' => __('dashboard.Image size must not exceed 5 MB.'),

            'cropped_image.required_without' => __('dashboard.Please crop or upload an image.'),
            'video_file.mimetypes' => __('dashboard.Video must be an MP4 file.'),
            'video_file.max' => __('dashboard.Video size must not exceed 100 MB.'),
            'pdf_file.mimetypes' => __('dashboard.File must be a PDF.'),
            'pdf_file.max' => __('dashboard.PDF size must not exceed 10 MB.'),
        ];
    }
}
