<?php

use App\Models\User_pages_permission;

if (!function_exists('checkingPages')) {
    function checkingPages()
    {
        $role_id = session('role_id');
        $current_page = session('current_page');

        if (!$role_id || !$current_page) {
            return null; // Return null if session variables are missing
        }

        return User_pages_permission::where('pages_id', $current_page)
            ->where('roles_id', $role_id)
            ->first();
    }
}
