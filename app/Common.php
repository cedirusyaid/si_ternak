<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('validation_errors')) {
    function validation_errors($prefix = '', $suffix = '') {
        $validation = \Config\Services::validation();
        $errors = $validation->getErrors();
        if (empty($errors)) {
            return '';
        }
        
        // If prefix/suffix is not provided, we default to standard layout
        if (empty($prefix) && empty($suffix)) {
            $prefix = '<div>';
            $suffix = '</div>';
        }
        
        $html = '';
        foreach ($errors as $error) {
            $html .= $prefix . esc($error) . $suffix;
        }
        return $html;
    }
}

if (! function_exists('uri_segment')) {
    function uri_segment(int $index) {
        $segments = service('request')->getUri()->getSegments();
        return $segments[$index - 1] ?? '';
    }
}

