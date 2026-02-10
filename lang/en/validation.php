<?php

return [
    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'current_password' => 'The current password is incorrect.',

    'min' => [
        'string' => 'The :attribute field must be at least :min characters.',
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
    ],
];
