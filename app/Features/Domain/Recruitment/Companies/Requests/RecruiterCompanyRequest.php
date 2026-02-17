<?php

namespace App\Features\Domain\Recruitment\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecruiterCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'company_tax_code' => 'required|string|max:100',
            'company_address' => 'required|string|max:500',
            'company_phone' => 'required|string|max:20',
            'company_email' => 'required|email|max:255',
            'company_website' => 'nullable|url|max:255',

            'company_size' => 'nullable|string|max:50',
            'company_industry' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',

            // upload file
            'company_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // 'verification_documents' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }
    public function messages(): array
    {
        return [
            // company info
            'company_name.required' => 'Tên công ty là bắt buộc.',
            'company_name.string' => 'Tên công ty phải là chuỗi.',
            'company_name.max' => 'Tên công ty không được vượt quá 255 ký tự.',

            'company_tax_code.required' => 'Mã số thuế là bắt buộc.',
            'company_tax_code.string' => 'Mã số thuế phải là chuỗi.',
            'company_tax_code.max' => 'Mã số thuế không được vượt quá 100 ký tự.',

            'company_address.required' => 'Địa chỉ công ty là bắt buộc.',
            'company_address.string' => 'Địa chỉ phải là chuỗi.',
            'company_address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',

            'company_phone.required' => 'Số điện thoại là bắt buộc.',
            'company_phone.string' => 'Số điện thoại phải là chuỗi.',
            'company_phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',

            'company_email.required' => 'Email công ty là bắt buộc.',
            'company_email.email' => 'Email không đúng định dạng.',
            'company_email.max' => 'Email không được vượt quá 255 ký tự.',

            'company_website.url' => 'Website phải là URL hợp lệ.',
            'company_website.max' => 'Website không được vượt quá 255 ký tự.',

            'company_size.string' => 'Quy mô công ty phải là chuỗi.',
            'company_size.max' => 'Quy mô công ty không được vượt quá 50 ký tự.',

            'company_industry.string' => 'Ngành nghề phải là chuỗi.',
            'company_industry.max' => 'Ngành nghề không được vượt quá 255 ký tự.',

            'company_description.string' => 'Mô tả công ty phải là chuỗi.',

            // upload file
            'company_image.image' => 'Logo phải là hình ảnh.',
            'company_image.mimes' => 'Logo chỉ chấp nhận jpg, jpeg, png, webp.',
            'company_image.max' => 'Logo không được vượt quá 2MB.',

            // 'verification_documents.file' => 'Tài liệu xác minh không hợp lệ.',
            // 'verification_documents.mimes' => 'Tài liệu chỉ chấp nhận pdf, jpg, jpeg, png.',
            // 'verification_documents.max' => 'Tài liệu không được vượt quá 5MB.',
        ];
    }
}