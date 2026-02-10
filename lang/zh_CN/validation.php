<?php

return [
    'required' => ':attribute 不能为空。',
    'string' => ':attribute 必须是字符串。',
    'confirmed' => ':attribute 与确认值不匹配。',
    'current_password' => '当前密码不正确。',

    'min' => [
        'string' => ':attribute 至少需要 :min 个字符。',
    ],

    'password' => [
        'letters' => ':attribute 必须包含至少一个字母。',
        'mixed' => ':attribute 必须同时包含大写和小写字母。',
        'numbers' => ':attribute 必须包含至少一个数字。',
        'symbols' => ':attribute 必须包含至少一个符号。',
        'uncompromised' => '给定的 :attribute 已出现在数据泄露中，请更换为其他值。',
    ],

    'attributes' => [
        'name' => '用户名',
        'email' => '邮箱',
        'password' => '密码',
        'password_confirmation' => '确认密码',
        'current_password' => '当前密码',
        'title' => '标题',
        'body' => '内容',
    ],
];
