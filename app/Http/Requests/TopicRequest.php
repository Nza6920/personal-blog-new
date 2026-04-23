<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        switch ($this->method()) {
            // CREATE
            case 'POST':
                // UPDATE
            case 'PUT':
            case 'PATCH':

                return [
                    'title' => 'required|min:2',
                    'body' => 'required|min:3',
                    'body_type' => 'nullable|in:MARKDOWN,HTML',
                    'cover_img' => 'nullable|image|max:500',
                ];

            case 'GET':
            case 'DELETE':
            default:

                return [];

        }
    }

    public function messages()
    {
        return [
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
}
