<?php

namespace App\Features\Domain\GroupStudent\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateGroupMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        // Ít nhất phải có content hoặc images
        return [
            'group_id' => 'required|integer|exists:groups,group_id',
            'content' => 'required_without_all:medias|string|max:5000',
            'medias' => 'required_without_all:content|array|max:10',
            'medias.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,webm,mov,doc,docx|max:5120',//'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => 'Vui lòng chọn nhóm.',
            'group_id.exists'   => 'Nhóm không tồn tại hoặc đã bị xóa.',

            'content.required_without_all' =>
                'Tin nhắn phải có nội dung hoặc ít nhất một tệp đính kèm.',
            'content.string' =>
                'Nội dung tin nhắn không hợp lệ.',
            'content.max' =>
                'Nội dung tin nhắn không được vượt quá 5000 ký tự.',

            'medias.required_without_all' =>
                'Vui lòng đính kèm ít nhất một tệp nếu không có nội dung tin nhắn.',
            'medias.array' =>
                'Danh sách tệp đính kèm không hợp lệ.',
            'medias.min' =>
                'Phải có ít nhất một tệp đính kèm.',
            'medias.max' =>
                'Chỉ được gửi tối đa 10 tệp trong một tin nhắn.',

            'medias.*.file' =>
                'Tệp đính kèm không hợp lệ.',
            'medias.*.mimes' =>
                'Định dạng tệp không được hỗ trợ. Chỉ cho phép ảnh (jpg, png, gif), video (mp4, webm, mov) và tài liệu (doc, docx).',
            'medias.*.max' =>
                'Mỗi tệp đính kèm không được vượt quá 5MB.',
        ];
    }

}
