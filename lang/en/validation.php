<?php

return [
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'current_password' => 'The current password is incorrect.',
    'image' => 'The :attribute field must be an image.',

    'min' => [
        'string' => 'The :attribute field must be at least :min characters.',
    ],

    'max' => [
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
    ],

    'custom' => [
        'cover_img' => [
            'max' => 'The cover image must not be greater than 500 KB.',
        ],
    ],

    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],

    'attributes' => [
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'current_password' => 'current password',
        'title' => 'title',
        'body' => 'content',
        'cover_img' => 'cover image',
    ],
];
