<?php

namespace App\Features\Domain\UserChat\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SendUserChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'receiver_id' => 'required|exists:users,user_id',
            'content' => 'required_without_all:medias|string|min:1|max:5000',
            'medias' => 'required_without_all:content|array|max:10',
            'medias.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,webm,mov,doc,docx,pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.required' => 'Vui lòng chọn người nhận.',
            'receiver_id.exists' => 'Người dùng không tồn tại.',

            'content.required_without_all' => 'Tin nhắn phải có nội dung hoặc ít nhất một tệp đính kèm.',
            'content.string' => 'Nội dung không hợp lệ.',
            'content.max' => 'Nội dung không được vượt quá 5000 ký tự.',

            'medias.required_without_all' => 'Vui lòng đính kèm ít nhất một tệp nếu không có nội dung.',
            'medias.array' => 'Danh sách tệp không hợp lệ.',
            'medias.max' => 'Chỉ được gửi tối đa 10 tệp.',

            'medias.*.file' => 'Tệp không hợp lệ.',
            'medias.*.mimes' => 'Định dạng tệp không được hỗ trợ.',
            'medias.*.max' => 'Mỗi tệp không được vượt quá 5MB.',
        ];
    }
}
