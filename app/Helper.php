<?php

if (!function_exists('response_success')) {
    function response_success($data = null) {
        return [
            'success' => true,
            'errors' => null,
            'data' => $data,
        ];
    }
}

if (!function_exists('response_error')) {
    function response_error($message = null) {
        return [
            'success' => false,
            'errors' => $message,
            'data' => null,
        ];
    }
}