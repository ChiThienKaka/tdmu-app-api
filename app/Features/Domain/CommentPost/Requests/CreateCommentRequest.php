<?php
namespace App\Features\Domain\CommentPost\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_id' => ['required', 'integer', 'exists:posts,post_id'],
            'content' => ['required', 'string', 'max:1000'],
            'parent_comment_id' => ['nullable', 'integer', 'exists:comments,comment_id'],
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'Post ID là bắt buộc',
            'post_id.integer' => 'Post ID phải là số nguyên',
            'post_id.exists' => 'Post không tồn tại',
            'content.required' => 'Nội dung bình luận là bắt buộc',
            'content.string' => 'Nội dung bình luận phải là chuỗi ký tự',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự',
            'parent_comment_id.integer' => 'Parent Comment ID phải là số nguyên',
            'parent_comment_id.exists' => 'Bình luận cha không tồn tại',
        ];
    }
}