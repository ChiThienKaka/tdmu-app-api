<?php

namespace App\Features\Domain\PostContext\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:5000',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Nội dung bài viết không được để trống.',
            'content.string' => 'Nội dung bài viết phải là chuỗi ký tự.',
            'content.max' => 'Nội dung bài viết không được vượt quá 5000 ký tự.',
            'images.array' => 'Hình ảnh phải được gửi dưới dạng mảng.',
            'images.max' => 'Không được gửi quá 10 hình ảnh cho mỗi bài viết.',
            'images.*.image' => 'Mỗi mục trong mảng hình ảnh phải là một hình ảnh hợp lệ.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Kích thước mỗi hình ảnh không được vượt quá 5MB.',
        ];
    }
}
