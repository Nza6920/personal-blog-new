<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));

    return Str::limit($excerpt, $length);
}

function clean($value, $config = null)
{
    if (class_exists(\Mews\Purifier\Facades\Purifier::class)) {
        return \Mews\Purifier\Facades\Purifier::clean($value, $config);
    }

    $allowed = '<p><br><b><strong><i><em><ul><ol><li><a><blockquote><code><pre><img>'
        .'<h1><h2><h3><h4><h5><h6>';

    return strip_tags($value, $allowed);
}
