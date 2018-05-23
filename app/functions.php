<?php

function fn_print_r(...$args) {
    
    echo "<pre style='background-color:black; color:lime'>";
    var_dump($args);
    echo "</pre>";
}

function fn_print_die(...$args) {
    
    call_user_func('fn_print_r', $args);
    die();
}

function asset($path, $is_https = false)
{   
    $base_url = is_https() ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'];

    return $base_url . '/assets/' . $path; 
}

function is_https() {

    if (defined('https')) {
        
        return true;
    }

    return false;
}

function base_url($path)
{   
    $base_url = is_https() ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'];

    return $base_url . '/' . $path; 
}

function method_field($method = 'PUT')
{   
    $field = '<input type="hidden" name="_METHOD" value="' . $method . '">';

    return $field; 
}