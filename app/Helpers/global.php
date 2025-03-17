<?php

use App\Models\User_pages_permission;
use App\Models\ReferenceNumber;
use App\Models\ReferenceGatepassNumber;
use App\Models\ApproversMatrix;
use App\Models\User;
use App\Models\ApproversStatus;
use App\Mail\MyTestEmail;
use App\Mail\ApprovalgatepassNotification;

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


if (!function_exists('generateGatepassNumber')) {
    function generateGatepassNumber()
    {
        // Find the last inserted reference number
        $lastReference = ReferenceGatepassNumber::latest('id')->first();

        // Extract numeric part and increment
        $nextNumber = $lastReference ? ((int) str_replace('ITGP-', '', $lastReference->reference_number) + 1) : 1;

        // Format to 7-digit number
        $formattedNumber = str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        // Create new reference number
        $ref = ReferenceGatepassNumber::create([
            'reference_number' => "ITGP-{$formattedNumber}",
            'createdby' => session('user_email')
        ]);

        return $ref->reference_number;
    }
}

function get_approvers($typeprocess){
    $approvers = ApproversMatrix::where('type_of_process', $typeprocess)->orderBy('increment_num', 'asc')->get();
    return $approvers;
}

function get_approvers_status($issuance_id, $user_id){
    $approvers = ApproversStatus::where('data_id', $issuance_id)->where()->get();
    return $approvers;
}

function get_current_approvers($id_data, $pages_id, $user_id){

    $exists = ApproversStatus::where('data_id', $id_data)
        ->where('pages_id', $pages_id)
        ->where('user_id', $user_id)
        ->exists();
        // echo "<pre>";
        // print_r($exists);
    if($exists){
        $approvers = ApproversStatus::where('data_id', $id_data)->where('pages_id', $pages_id)->where('user_id', $user_id)->first();
        $approvers->isNew = "N";
    }else{
        $approvers = new ApproversStatus();
        $approvers->data_id = $id_data;
        $approvers->pages_id = $pages_id;
        $approvers->user_id = $user_id;
        $approvers->status = "NA";
        $approvers->save();
        $approvers->isNew = "Y";
        
    }
    // echo "<pre>";
    // print_r($approvers);
    // exit;
    return [
        'status' => $approvers->status,
        'status_id' => $approvers->id,
        'isNew' => $approvers->isNew
    ];
    // return $approvers;

}


if (!function_exists('approvalIssuance')) {
    function approvalIssuance($issuance_id, $typeprocess, $pages_id, $rev_num, $issueby, $assignee, $date_req, $date_need)
    {
        $approvers = get_approvers($typeprocess);
        $approvers = $approvers->toArray();
        $next_approver = "";
        foreach ($approvers as $key => $value) {

            $user_data = User::find($value["user_id"]);
            $name = $user_data->name;
            $email = $user_data->email;
            $data = get_current_approvers($issuance_id, $pages_id, $value["user_id"]);
            if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
            
                $change1 = ApproversStatus::find($data["status_id"]);
                $change1->status = "P";
                $change1->save();
                $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                Mail::to($email)->send(new MyTestEmail($name, $subject, $rev_num, $issueby, $assignee, $date_req, $date_need, $pages_id, $value["user_id"]));
                continue;
            }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                $change1 = ApproversStatus::find($data["status_id"]);
                if($change1->status  === "P"){
                    break;
                }else{
                    $change1->status = "P";
                    $change1->save();
                    $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                    // $name = User::find($value["user_id"])->name;
                    Mail::to($email)->send(new MyTestEmail($name, $subject, $rev_num, $issueby, $assignee, $date_req, $date_need, $pages_id, $value["user_id"]));
                    $next_approver =  $name;
                    break;
                }
                
            }else{
                if($data["status"] === "A"){
                    continue;
                }
            }

            // echo $data["status"] . " <> " . $value["increment_num"] . " <> " . $value["user_id"] . "<br>";
        }

        return $next_approver;
        
    }

}


if (!function_exists('approvalGatepass')) {
    function approvalGatepass($gatepass_id, $typeprocess, $pages_id)
    {
        $approvers = get_approvers($typeprocess);
        $approvers = $approvers->toArray();
        // echo "<pre>";
        // print_r($approvers);
        // exit;
        $next_approver = "";
        foreach ($approvers as $key => $value) {

            $user_data = User::find($value["user_id"]);
            $name = $user_data->name;
            $email = $user_data->email;
            $data = get_current_approvers($gatepass_id, $pages_id, $value["user_id"]);
            if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
            
                $change1 = ApproversStatus::find($data["status_id"]);
                $change1->status = "P";
                $change1->save();
                Mail::to("christian.villamer@jakagroup.com")->send(new ApprovalgatepassNotification($gatepass_id, $pages_id, $value["user_id"]));
                continue;
            }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                $change1 = ApproversStatus::find($data["status_id"]);
                if($change1->status  === "P"){
                    break;
                }else{
                    $change1->status = "P";
                    $change1->save();
                    // $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                    // $name = User::find($value["user_id"])->name;
                    Mail::to("christian.villamer@jakagroup.com")->send(new ApprovalgatepassNotification($gatepass_id, $pages_id, $value["user_id"]));
                    $next_approver =  $name;
                    break;
                }
                
            }else{
                if($data["status"] === "A"){
                    continue;
                }
            }

            // echo $data["status"] . " <> " . $value["increment_num"] . " <> " . $value["user_id"] . "<br>";
        }

        return $next_approver;
        
    }

}