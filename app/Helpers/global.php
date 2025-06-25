<?php

use App\Models\User_pages_permission;
use App\Models\ReferenceNumber;
use App\Models\ReferenceGatepassNumber;
use App\Models\ApproversMatrix;
use App\Models\User;
use App\Models\Asset;
use App\Models\ApproversStatus;
use App\Mail\MyTestEmail;
use App\Mail\BorrowedNotif;
use App\Mail\ApprovalgatepassNotification;
use App\Mail\AssetTransferNotification;
use App\Models\AssetAssigns;
use App\Models\AssetReturnReference;
use App\Models\AssetBorrowedRef;
use App\Models\AssetDisposalRef;
use App\Mail\AssetDsiposalApprovalReq;

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



if (!function_exists('generateAssetReturnsNumber')) {
    function generateAssetReturnsNumber()
    {
        // Find the last inserted reference number
        $lastReference = AssetReturnReference::latest('id')->first();

        // Extract numeric part and increment
        $nextNumber = $lastReference ? ((int) str_replace('ITRT-', '', $lastReference->reference_number) + 1) : 1;

        // Format to 7-digit number
        $formattedNumber = str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        // Create new reference number
        $ref = AssetReturnReference::create([
            'reference_number' => "ITRT-{$formattedNumber}",
            'createdby' => session('user_email')
        ]);

        return $ref->reference_number;
    }
}

if (!function_exists('generateAssetReturnsNumber')) {
    function generateAssetReturnsNumber()
    {
        // Find the last inserted reference number
        $lastReference = AssetReturnReference::latest('id')->first();

        // Extract numeric part and increment
        $nextNumber = $lastReference ? ((int) str_replace('ITRT-', '', $lastReference->reference_number) + 1) : 1;

        // Format to 7-digit number
        $formattedNumber = str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        // Create new reference number
        $ref = AssetReturnReference::create([
            'reference_number' => "ITRT-{$formattedNumber}",
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
    function approvalIssuance($issuance_id, $typeprocess, $pages_id, $rev_num, $issueby, $assignee, $date_req, $date_need, $the_status)
    {

        if($the_status == "RE"){
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {
                
                $data1 = get_current_approvers($issuance_id, $pages_id, $value["user_id"]);
                $change1 = ApproversStatus::find($data1["status_id"]);
                if ($change1) {
                    $change1->status = "NA"; // Reset status
                    $change1->uid = ""; // Reset status
                    $change1->remarks = ""; // Reset status
                    $change1->save();
                }
            }


            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                // $email = "christian.villamer@jakagroup.com";
                $data = get_current_approvers($issuance_id, $pages_id, $value["user_id"]);
                if($data["status"] === "NA" && $value["increment_num"] == 1 && ($data["isNew"] === "Y" || $data["isNew"] === "N")){
                
                    $change1 = ApproversStatus::find($data["status_id"]);
                    $change1->status = "P";
                    $change1->save();
                    $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                    Mail::to($email)->send(new MyTestEmail($name, $subject, $rev_num, $issueby, $assignee, $date_req, $date_need, $pages_id, $value["user_id"]));
                    break;
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
            // echo "<pre>";
            // print_r($approvers);
            // exit;

        }else{
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                // $email = "christian.villamer@jakagroup.com";
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
            // $email = "christian.villamer@jakagroup.com";
            $data = get_current_approvers($gatepass_id, $pages_id, $value["user_id"]);
            if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
            
                $change1 = ApproversStatus::find($data["status_id"]);
                $change1->status = "P";
                $change1->save();
                Mail::to($email)->send(new ApprovalgatepassNotification($gatepass_id, $pages_id, $value["user_id"]));
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
                    Mail::to($email)->send(new ApprovalgatepassNotification($gatepass_id, $pages_id, $value["user_id"]));
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










if (!function_exists('approvalAssetTransfer')) {
    function approvalAssetTransfer($transfer_id, $typeprocess, $pages_id, $the_status = "P")
    {
        try {
            if($the_status == "RE"){
                $approvers = get_approvers($typeprocess);
                $approvers = $approvers->toArray();
                $next_approver = "";
                foreach ($approvers as $key => $value) {
                    
                    $data1 = get_current_approvers($transfer_id, $pages_id, $value["user_id"]);
                    $change1 = ApproversStatus::find($data1["status_id"]);
                    if ($change1) {
                        $change1->status = "NA"; // Reset status
                        $change1->uid = ""; // Reset status
                        $change1->remarks = ""; // Reset status
                        $change1->save();
                    }
                }
    
    
                $next_approver = "";
                foreach ($approvers as $key => $value) {
    
                    $user_data = User::find($value["user_id"]);
                    $name = $user_data->name;
                    $email = $user_data->email;
                    // $email = "christian.villamer@jakagroup.com";
                    $data = get_current_approvers($transfer_id, $pages_id, $value["user_id"]);
                    if($data["status"] === "NA" && $value["increment_num"] == 1 && ($data["isNew"] === "Y" || $data["isNew"] === "N")){
                    
                        $change1 = ApproversStatus::find($data["status_id"]);
                        $change1->status = "P";
                        $change1->save();
                        $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                        Mail::to($email)->send(new AssetTransferNotification($transfer_id, $pages_id, $value["user_id"]));
                        break;
                    }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                        $change1 = ApproversStatus::find($data["status_id"]);
                        if($change1->status  === "P"){
                            break;
                        }else{
                            $change1->status = "P";
                            $change1->save();
                            $subject = "Approval Request for Issuance of Asset - Rev :" . $rev_num;
                            // $name = User::find($value["user_id"])->name;
                            Mail::to($email)->send(new AssetTransferNotification($transfer_id, $pages_id, $value["user_id"]));
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
                // echo "<pre>";
                // print_r($approvers);
                // exit;
    
            }else{
                $approvers = get_approvers($typeprocess);
                $approvers = $approvers->toArray();
                $next_approver = "";
                foreach ($approvers as $key => $value) {
    
                    $user_data = User::find($value["user_id"]);
                    $name = $user_data->name;
                    $email = $user_data->email;
                    // $email = "christian.villamer@jakagroup.com";
                    $data = get_current_approvers($transfer_id, $pages_id, $value["user_id"]);
                    // echo "<pre>";
                    // print_r($data);
                    // exit;
                    if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
                    
                        $change1 = ApproversStatus::find($data["status_id"]);
                        $change1->status = "P";
                        $change1->save();
                        Mail::to($email)->send(new AssetTransferNotification($transfer_id, $pages_id, $value["user_id"]));
                        continue;
                    }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                        $change1 = ApproversStatus::find($data["status_id"]);
                        if($change1->status  === "P"){
                            break;
                        }else{
                            $change1->status = "P";
                            $change1->save();
                            Mail::to($email)->send(new AssetTransferNotification($transfer_id, $pages_id, $value["user_id"]));
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
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'data' => $th->getMessage()
            ], 400);
        }
        
        
        
    }

}





if (!function_exists('generate_asset_borrowed_ref')) {
    function generate_asset_borrowed_ref()
    {
        $year = date('Y'); // Get the current year

        // Find the last reference number for the current year
        $lastReference = AssetBorrowedRef::where('reference_number', 'LIKE', "{$year}-MIS-AIT-%")
            ->latest('id')
            ->first();

        // Extract numeric part and increment
        if ($lastReference) {
            $lastNumber = (int) substr($lastReference->reference_number, -4); // Get last 4 digits
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1; // Start from 0001 if no previous record in the year
        }

        // Format number to 4-digit
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Generate reference number
        $referenceNumber = "{$year}-MIS-AIT-{$formattedNumber}";

        // Create new record with the reference number
        $ref = AssetBorrowedRef::create([
            'reference_number' => $referenceNumber,
            'createdby' => session('user_email'),
        ]);

        return $ref->reference_number;
    }
}



if (!function_exists('approvalBorrowedAsset')) {
    function approvalBorrowedAsset($borrowed_id, $typeprocess, $pages_id, $the_status)
    {

        if($the_status == "RE"){
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {
                
                $data1 = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                $change1 = ApproversStatus::find($data1["status_id"]);
                if ($change1) {
                    $change1->status = "NA"; // Reset status
                    $change1->uid = ""; // Reset status
                    $change1->remarks = ""; // Reset status
                    $change1->save();
                }
            }


            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                // $email = "christian.villamer@jakagroup.com";
                $data = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                if($data["status"] === "NA" && $value["increment_num"] == 1 && ($data["isNew"] === "Y" || $data["isNew"] === "N")){
                
                    $change1 = ApproversStatus::find($data["status_id"]);
                    $change1->status = "P";
                    $change1->save();
                    Mail::to($email)->send(new BorrowedNotif($borrowed_id, $pages_id, $value["user_id"]));
                    break;
                }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                    $change1 = ApproversStatus::find($data["status_id"]);
                    if($change1->status  === "P"){
                        break;
                    }else{
                        $change1->status = "P";
                        $change1->save();
                        Mail::to($email)->send(new BorrowedNotif($borrowed_id, $pages_id, $value["user_id"]));
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
            // echo "<pre>";
            // print_r($approvers);
            // exit;

        }else{
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                // $email = "christian.villamer@jakagroup.com";
                $data = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
                
                    $change1 = ApproversStatus::find($data["status_id"]);
                    $change1->status = "P";
                    $change1->save();
                    Mail::to($email)->send(new BorrowedNotif($borrowed_id, $pages_id, $value["user_id"]));
                    continue;
                }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                    $change1 = ApproversStatus::find($data["status_id"]);
                    if($change1->status  === "P"){
                        break;
                    }else{
                        $change1->status = "P";
                        $change1->save();
                        Mail::to($email)->send(new BorrowedNotif($borrowed_id, $pages_id, $value["user_id"]));
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

}


if (!function_exists('generateAssetDisposalNumber')) {
    function generateAssetDisposalNumber()
    {
        // Find the last inserted reference number
        $lastReference = AssetDisposalRef::latest('id')->first();

        // Extract numeric part and increment
        $nextNumber = $lastReference ? ((int) str_replace('DIS-', '', $lastReference->reference_number) + 1) : 1;

        // Format to 7-digit number
        $formattedNumber = str_pad($nextNumber, 7, '0', STR_PAD_LEFT);

        // Create new reference number
        $ref = AssetDisposalRef::create([
            'reference_number' => "DIS-{$formattedNumber}",
            'createdby' => session('user_email')
        ]);

        return $ref->reference_number;
    }
}


if (!function_exists('approvalAssetDisposalAsset')) {
    function approvalAssetDisposalAsset($borrowed_id, $typeprocess, $pages_id, $the_status)
    {

        if($the_status == "RE"){
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {
                
                $data1 = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                $change1 = ApproversStatus::find($data1["status_id"]);
                if ($change1) {
                    $change1->status = "NA"; // Reset status
                    $change1->uid = ""; // Reset status
                    $change1->remarks = ""; // Reset status
                    $change1->save();
                }
            }


            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                // $email = "christian.villamer@jakagroup.com";
                $data = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                if($data["status"] === "NA" && $value["increment_num"] == 1 && ($data["isNew"] === "Y" || $data["isNew"] === "N")){
                
                    $change1 = ApproversStatus::find($data["status_id"]);
                    $change1->status = "P";
                    $change1->save();
                    Mail::to($email)->send(new AssetDsiposalApprovalReq($borrowed_id, $pages_id, $value["user_id"]));
                    break;
                }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                    $change1 = ApproversStatus::find($data["status_id"]);
                    if($change1->status  === "P"){
                        break;
                    }else{
                        $change1->status = "P";
                        $change1->save();
                        Mail::to($email)->send(new AssetDsiposalApprovalReq($borrowed_id, $pages_id, $value["user_id"]));
                        $next_approver =  $name;
                        break;
                    }
                    
                }else{
                    if($data["status"] === "A"){
                        continue;
                    }
                }
            }
            return $next_approver;
        }else{
            $approvers = get_approvers($typeprocess);
            $approvers = $approvers->toArray();
            $next_approver = "";
            foreach ($approvers as $key => $value) {

                $user_data = User::find($value["user_id"]);
                $name = $user_data->name;
                $email = $user_data->email;
                $email = "christian.villamer@jakagroup.com";
                $data = get_current_approvers($borrowed_id, $pages_id, $value["user_id"]);
                if($data["status"] === "NA" && $value["increment_num"] == 1 && $data["isNew"] === "Y"){
                
                    $change1 = ApproversStatus::find($data["status_id"]);
                    $change1->status = "P";
                    $change1->save();
                    Mail::to($email)->send(new AssetDsiposalApprovalReq($borrowed_id, $pages_id, $value["user_id"]));
                    continue;
                }else if($data["status"] === "NA" && $value["increment_num"] > 1 && $data["isNew"] === "N"){
                    $change1 = ApproversStatus::find($data["status_id"]);
                    if($change1->status  === "P"){
                        break;
                    }else{
                        $change1->status = "P";
                        $change1->save();
                        Mail::to($email)->send(new AssetDsiposalApprovalReq($borrowed_id, $pages_id, $value["user_id"]));
                        $next_approver =  $name;
                        break;
                    }
                    
                }else{
                    if($data["status"] === "A"){
                        continue;
                    }
                }
            }

            return $next_approver;
        }
        
        
    }

}



if (!function_exists('changing_assetstatus')) {
    function changing_assetstatus($asset_id, $status_id){
        $data = Asset::find($asset_id);
        $data->asset_status_id = $status_id;
        $data->save();
        return $data;
    }
}


if (!function_exists('asset_assign_changes')) {
    function asset_assign_changes($asset_id, $emp_id, $status, $current = false){
        if($current){
            $data = AssetAssigns::where('asset_id', $asset_id)->where('status', $status)->first();
        }else{
            // $data = AssetAssigns::where('asset_id', $asset_id)->where('status', $status)->get();
            $data = new AssetAssigns();
            $data->employee_id = $emp_id;
            $data->asset_id = $asset_id;
            $data->status = "TRUE";
            $data->createdby = session('user_email');
            $data->updatedby = session('user_email');
            $data->save();
        }
        
        return $data;
    }
}



if (!function_exists('asset_assignee')) {
    function asset_assignee($asset_id, $emp_id){
        try {
            //1 unassigned the past assigne employee
            $data2 = AssetAssigns::where('asset_id', $asset_id)->where('status', 'TRUE')->get();
            if($data2){
                foreach($data2 as $key => $value){
                    $data1 = AssetAssigns::find($value->id);
                    $data1->status = "FALSE";
                    $data1->updatedby = session('user_email');
                    $data1->updated_at = now();
                    $data1->save();
                }
            }
            //2 assign the new employee
            $data = new AssetAssigns();
            $data->employee_id = $emp_id;
            $data->asset_id = $asset_id;
            $data->status = "TRUE";
            $data->createdby = session('session_email');
            $data->updatedby = session('session_email');
            $data->created_at = now();
            $data->updated_at = now();
            $data->save();

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'message' => 'changed successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ], 400);
        }
        
    }
}
