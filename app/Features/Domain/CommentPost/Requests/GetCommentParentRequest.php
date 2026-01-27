<?php
namespace App\Features\Domain\CommentPost\Requests;
use Illuminate\Foundation\Http\FormRequest;

class GetCommentParentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required', 'integer', 'exists:posts,post_id'],
            'per_page' => ['nullable', 'integer', 'max:50']
        ];
    }
    public function messages(): array
    {
        return [
            'post_id.required' => 'Post ID là bắt buộc',
            'post_id.integer' => 'Post ID phải là số nguyên',
            'post_id.exists' => 'Post không tồn tại',
            'per_page.integer'=> 'per_page phải là số nguyên',
            'per_page.max' => 'per_page không được vượt quá 50'
        ];
    }
}
