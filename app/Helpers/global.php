<?php

use App\Models\User_pages_permission;
use App\Models\ReferenceNumber;


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



if (!function_exists('generateRefNumber')) {
    function generateRefNumber()
    {
        $year = date('Y'); // Get the current year (e.g., 2025)

        // Count how many references exist for the current year
        $count = ReferenceNumber::whereYear('created_at', $year)->count() + 1;

        // Format count as a two-digit number
        $countFormatted = str_pad($count, 2, '0', STR_PAD_LEFT);

        $ref = ReferenceNumber::create(['reference_number' => "00-{$year}-00{$countFormatted}", 'createdby' => session('user_email')]);
        // Construct the reference number
        return $ref->reference_number;
    }
}