<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Issuance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">IT Asset Issuance Form rev {{ $asset_issuance->rev_num  }}</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                @if ($asset_issuance->is_finalized && $asset_issuance->approved_status == "P")
                                    <div class="alert alert-success text-center" role="alert">
                                        This issuance is already finalized.
                                    </div>
                                @elseif ($asset_issuance->approved_status == "A")
                                <div class="row">
                                    <div class="card-title col-6">
                                        <a type="button" class="btn btn-outline-success" href="/AssetAssign/issuance_pdf/{{ $asset_issuance->id }}"  target="_blank"><i class="las la-print"></i>Print Issuance</a>
                                        <button type="button" class="btn btn-outline-primary"><i class="las la-print"></i>Print Gatepass</button>
                                    </div>
                                    {{-- <div class="card-title col-6 text-end">
                                        <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                            Add Employee
                                            <span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                            </span>
                                        </a>
                                    </div> --}}
                                </div>
                                @endif
                                {{-- <form class="needs-validation" action="{{ Route('AssetAssign.add') }}" method="post" enctype="multipart/form-data"> --}}
                                    @csrf
                                    <h5 class="card-title">Assignee Information</h5>
                                    
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class=" col-4">
                                                    <label class="form-label">Employee number<span class="text-red">*</span></label>
                                                    <p class="form-control-plaintext"><b>{{ $employee_data->emp_no }}</b></p> 
                                                </div>
                                                <div class=" col-4">
                                                    <label class="form-label">Name</label>
                                                    <p class="form-control-plaintext" id="name_data"><b>{{ $employee_data->first_name . " " .  $employee_data->last_name }}</b></p>
                                                </div>
                                                <div class=" col-4">
                                                    <label class="form-label">Designation</label>
                                                    <p class="form-control-plaintext" id="position_data">{{ $employee_data->position->position_name ?? "" }}</p>
                                                </div>
                                            </div>
                                            

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Business unit</label>
                                                    <p class="form-control-plaintext" id="company_data"><b>{{ $employee_data->company->name ?? ""  }}</b></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Department</label>
                                                    <p class="form-control-plaintext" id="department_data"><b>{{ $employee_data->department->name ?? ""  }}</b></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Reports To<span class="text-red">*</span></label>
                                                    <p class="form-control-plaintext" id="reports_to"><b>{{ $asset_issuance->reports_to ?? ""  }}</b></p>
                                                </div>
                                                <div class=" col-md-3">
                                                    <label class="form-label">Location<span class="text-red">*</span></label>
                                                    <p class="form-control-plaintext" id="reports_to"><b>{{ $asset_issuance->getLocation->name ?? ""  }}</b></p>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Deployment Type:</label>
                                                    <p class="form-control-plaintext">
                                                        <b>{{ $asset_issuance->deployment_type == 'temporary' ? 'For temporary' : 'For permanent' }}</b>
                                                    </p>
                                                </div>
                                            
                                                <div class="col-md-9">
                                                    <label class="form-label">Duration</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">From</label>
                                                            <p class="form-control-plaintext"><b>{{ $asset_issuance->deployment_duration_from ?? ""  }}</b></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">To</label>
                                                            <p class="form-control-plaintext"><b>{{ $asset_issuance->deployment_duration_to ?? ""  }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Date Requested</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->date_requested ?? ""  }}</b></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Date Needed</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->date_needed ?? ""  }}</b></p>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Ref. RSS Ticket Numbers</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->ref_rss   }}</b></p>
                                                </div>

                                                <input type="hidden" name="issuance_id" id="issuance_id" value="{{ $asset_issuance->id }}">
                                            </div>

                                            <div class="row" id="HIN_id">
                                                <hr>
                                                <h5 class="card-title">Hardware Information</h5>
                                                <div class="table-responsive">
                                                    @if ($asset_issuance->is_finalized)
                                                    <table id="example2" class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Asset Tag</th>
                                                                <th>Category</th>
                                                                <th>Model</th>
                                                                <th>Serial No.</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                        
                                                            @foreach ($issuance_detl as $detl)
                                                                    @if ($asset_issuance->is_finalized)
                                                                        
                                                                    <tr>
                                                                        <td>{{ $detl->asset_details->asset_id }}</td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->category_data->name }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->model_no }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->serial_number }}</span></td>
                                                                        <td>
                                                                            {{-- <button type="button" id="save_0" class="btn btn-outline-primary"  data-toggle="modal" data-target="#EmployeeInfo" data-details_id="{{ $detl->id }}" asset_id_data="{{ $detl->asset_details->id }}">Details</button> --}}
                                                                            <button type="button" id="save_0" class="btn btn-outline-primary"  
                                                                            data-os_version="{{ $detl->os_patch_ver  }}"
                                                                            data-isMSoffice="{{ $detl->isMSoffice }}"
                                                                            data-isHCS="{{ $detl->isHCS }}"
                                                                            data-isNetSuite="{{ $detl->isNetSuite }}"
                                                                            data-isAcrobat_r="{{ $detl->isAcrobat_r }}"
                                                                            data-isAcrobat_a="{{ $detl->isAcrobat_a }}"
                                                                            data-others="{{ $detl->others }}"
                                                                            data-pheripherals="{{ $detl->peripherals }}"
                                                                            data-int_isfull="{{ $detl->int_isfull }}"
                                                                            data-int_islimited="{{ $detl->int_islimited }}"
                                                                            data-int_isNone="{{ $detl->int_isNone }}"
                                                                            data-int_isvoip_ext="{{ $detl->int_isvoip_ext }}"
                                                                            data-int_isvoip_ext_detls="{{ $detl->int_isvoip_ext_detls }}"
                                                                            data-int_ispbx_ext="{{ $detl->int_ispbx_ext }}"
                                                                            data-int_ispbx_ext_detls="{{ $detl->int_ispbx_ext_detls }}"
                                                                            data-int_wifi_ssid="{{ $detl->int_wifi_ssid }}"
                                                                            data-int_shared_drive="{{ $detl->int_shared_drives }}"
                                                                            data-int_shared_printer="{{ $detl->int_shared_printers }}"
                                                                            data-int_ip_assign="{{ $detl->int_ip_assign }}"
                                                                            data-int_subnet="{{ $detl->int_subnet }}"
                                                                            data-int_mac_add="{{ $detl->int_mac_address }}"
                                                                            data-int_net_group="{{ $detl->int_network_group }}"
                                                                            onclick="getdataall_view({{ $detl->id }}, {{ $detl->asset_details->id }})">Details</button>
                                                                        </td>
                                                                    </tr>
                                                                    @else
                                                                    
                                                                    <tr>
                                                                        <td>{{ $detl->asset_details->asset_id }}</td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->category_data->name }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->model_no }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->serial_number }}</span></td>
                                                                        <td>
                                                                            {{-- <button type="button" id="save_0" class="btn btn-outline-primary"  data-toggle="modal" data-target="#EmployeeInfo" data-details_id="{{ $detl->id }}" asset_id_data="{{ $detl->asset_details->id }}">Details</button> --}}
                                                                            <button type="button" id="save_0_view" class="btn btn-outline-primary"  
                                                                            data-os_version="{{ $detl->os_patch_ver  }}"
                                                                            data-isMSoffice="{{ $detl->isMSoffice }}"
                                                                            data-isHCS="{{ $detl->isHCS }}"
                                                                            data-isNetSuite="{{ $detl->isNetSuite }}"
                                                                            data-isAcrobat_r="{{ $detl->isAcrobat_r }}"
                                                                            data-isAcrobat_a="{{ $detl->isAcrobat_a }}"
                                                                            data-others="{{ $detl->others }}"
                                                                            data-pheripherals="{{ $detl->peripherals }}"
                                                                            data-int_isfull="{{ $detl->int_isfull }}"
                                                                            data-int_islimited="{{ $detl->int_islimited }}"
                                                                            data-int_isNone="{{ $detl->int_isNone }}"
                                                                            data-int_isvoip_ext="{{ $detl->int_isvoip_ext }}"
                                                                            data-int_isvoip_ext_detls="{{ $detl->int_isvoip_ext_detls }}"
                                                                            data-int_ispbx_ext="{{ $detl->int_ispbx_ext }}"
                                                                            data-int_ispbx_ext_detls="{{ $detl->int_ispbx_ext_detls }}"
                                                                            data-int_wifi_ssid="{{ $detl->int_wifi_ssid }}"
                                                                            data-int_shared_drive="{{ $detl->int_shared_drives }}"
                                                                            data-int_shared_printer="{{ $detl->int_shared_printers }}"
                                                                            data-int_ip_assign="{{ $detl->int_ip_assign }}"
                                                                            data-int_subnet="{{ $detl->int_subnet }}"
                                                                            data-int_mac_add="{{ $detl->int_mac_address }}"
                                                                            data-int_net_group="{{ $detl->int_network_group }}"
                                                                            onclick="getdataall({{ $detl->id }}, {{ $detl->asset_details->id }})">Details</button>
                                                                            <button type="button" class="btn btn-outline-danger" onclick="getDelete({{ $detl->id  }})">Delete</button>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                
                                                                    @endif
                                                                
                                                            @endforeach

                                                            
                                                            
                                                        </tbody>
                                                        
                                                    </table>
                                                
                                                    @else
                                                    <table id="example3" class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Asset Tag</th>
                                                                <th>Category</th>
                                                                <th>Model</th>
                                                                <th>Serial No.</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @php
                                                            $x = 0;
                                                        @endphp


                                                            @foreach ($issuance_detl as $detl)
                                                                    @if ($asset_issuance->is_finalized)
                                                                        
                                                                    <tr>
                                                                        <td>{{ $detl->asset_details->asset_id }}</td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->category_data->name }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->model_no }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->serial_number }}</span></td>
                                                                        <td>
                                                                            {{-- <button type="button" id="save_0" class="btn btn-outline-primary"  data-toggle="modal" data-target="#EmployeeInfo" data-details_id="{{ $detl->id }}" asset_id_data="{{ $detl->asset_details->id }}">Details</button> --}}
                                                                            <button type="button" id="save_0" class="btn btn-outline-primary"  
                                                                            data-os_version="{{ $detl->os_patch_ver  }}"
                                                                            data-isMSoffice="{{ $detl->isMSoffice }}"
                                                                            data-isHCS="{{ $detl->isHCS }}"
                                                                            data-isNetSuite="{{ $detl->isNetSuite }}"
                                                                            data-isAcrobat_r="{{ $detl->isAcrobat_r }}"
                                                                            data-isAcrobat_a="{{ $detl->isAcrobat_a }}"
                                                                            data-others="{{ $detl->others }}"
                                                                            data-pheripherals="{{ $detl->peripherals }}"
                                                                            data-int_isfull="{{ $detl->int_isfull }}"
                                                                            data-int_islimited="{{ $detl->int_islimited }}"
                                                                            data-int_isNone="{{ $detl->int_isNone }}"
                                                                            data-int_isvoip_ext="{{ $detl->int_isvoip_ext }}"
                                                                            data-int_isvoip_ext_detls="{{ $detl->int_isvoip_ext_detls }}"
                                                                            data-int_ispbx_ext="{{ $detl->int_ispbx_ext }}"
                                                                            data-int_ispbx_ext_detls="{{ $detl->int_ispbx_ext_detls }}"
                                                                            data-int_wifi_ssid="{{ $detl->int_wifi_ssid }}"
                                                                            data-int_shared_drive="{{ $detl->int_shared_drives }}"
                                                                            data-int_shared_printer="{{ $detl->int_shared_printers }}"
                                                                            data-int_ip_assign="{{ $detl->int_ip_assign }}"
                                                                            data-int_subnet="{{ $detl->int_subnet }}"
                                                                            data-int_mac_add="{{ $detl->int_mac_address }}"
                                                                            data-int_net_group="{{ $detl->int_network_group }}"
                                                                            onclick="getdataall_view({{ $detl->id }}, {{ $detl->asset_details->id }})">Details</button>
                                                                        </td>
                                                                    </tr>
                                                                    @else
                                                                    <tr>
                                                                        <td>{{ $detl->asset_details->asset_id }}</td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->category_data->name }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->model_no }}</span></td>
                                                                        <td><span class="text-center">{{ $detl->asset_details->serial_number }}</span></td>
                                                                        <td>
                                                                            {{-- <button type="button" id="save_0" class="btn btn-outline-primary"  data-toggle="modal" data-target="#EmployeeInfo" data-details_id="{{ $detl->id }}" asset_id_data="{{ $detl->asset_details->id }}">Details</button> --}}
                                                                            <button type="button" id="save_0" class="btn btn-outline-primary"  
                                                                            data-os_version="{{ $detl->os_patch_ver  }}"
                                                                            data-isMSoffice="{{ $detl->isMSoffice }}"
                                                                            data-isHCS="{{ $detl->isHCS }}"
                                                                            data-isNetSuite="{{ $detl->isNetSuite }}"
                                                                            data-isAcrobat_r="{{ $detl->isAcrobat_r }}"
                                                                            data-isAcrobat_a="{{ $detl->isAcrobat_a }}"
                                                                            data-others="{{ $detl->others }}"
                                                                            data-pheripherals="{{ $detl->peripherals }}"
                                                                            data-int_isfull="{{ $detl->int_isfull }}"
                                                                            data-int_islimited="{{ $detl->int_islimited }}"
                                                                            data-int_isNone="{{ $detl->int_isNone }}"
                                                                            data-int_isvoip_ext="{{ $detl->int_isvoip_ext }}"
                                                                            data-int_isvoip_ext_detls="{{ $detl->int_isvoip_ext_detls }}"
                                                                            data-int_ispbx_ext="{{ $detl->int_ispbx_ext }}"
                                                                            data-int_ispbx_ext_detls="{{ $detl->int_ispbx_ext_detls }}"
                                                                            data-int_wifi_ssid="{{ $detl->int_wifi_ssid }}"
                                                                            data-int_shared_drive="{{ $detl->int_shared_drives }}"
                                                                            data-int_shared_printer="{{ $detl->int_shared_printers }}"
                                                                            data-int_ip_assign="{{ $detl->int_ip_assign }}"
                                                                            data-int_subnet="{{ $detl->int_subnet }}"
                                                                            data-int_mac_add="{{ $detl->int_mac_address }}"
                                                                            data-int_net_group="{{ $detl->int_network_group }}"
                                                                            onclick="getdataall({{ $detl->id }}, {{ $detl->asset_details->id }})">Details</button>
                                                                            <button type="button" class="btn btn-outline-danger" onclick="getDelete({{ $detl->id  }})">Delete</button>
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $x++;
                                                                    @endphp
                                                                    @endif
                                                                
                                                            @endforeach
                                                            
                                                        </tbody>

                                                    </table>
                                                    <input type="hidden" id="last_count_data" value="{{ $x }}">
                                                    @endif
                                                    
                                                </div>
                                                
                                            </div>
                                            <hr>
                                        </div>
                                        @if (!$asset_issuance->is_finalized)
                                            <button class="btn btn-primary mt-4 w-100" type="submit" onclick="final_data()">Finalize</button>
                                        @else
                                        <div class="row">
                                            <h5 class="card-title">Approvers</h5>
                                            
                                                @foreach ($issuance_status as $data)
                                                <div class="mb-3 col-sm-4 text-center">
                                                    <label for="employee_name" class="form-label"><b>{{  $data->user->name }}</b></label>
                                                    <p>uid: {{  $data->uid }}</p>
                                                    <br>

                                                    @if ($data->user->id == Auth::user()->id && $data->status == 'P')
                                                        <div class="d-flex gap-1">
                                                            <button type="button" class="btn btn-outline-success flex-fill" id="btn_approved_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="A" data-asset_iss_id="{{ $asset_issuance->id }}">Approved</button>
                                                            <button type="button" class="btn btn-outline-danger flex-fill" id="btn_reject_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="R" data-asset_iss_id="{{ $asset_issuance->id }}">Reject</button>
                                                            
                                                        </div>
                                                        
                                                    @else

                                                    <label for="employee_name" class="form-label">
                                                            
                                                        @switch($data->status)
                                                            @case('P')
                                                                <div class="alert alert-info" role="alert">
                                                                    Pending
                                                                </div>
                                                                @break
                                                            @case('NA')
                                                                <div class="alert alert-primary" role="alert">
                                                                    Waiting for Approval
                                                                </div>
                                                                @break
                                                            @case('A')
                                                                <div class="alert alert-success" role="alert">
                                                                    Approved
                                                                </div>
                                                                @break
                                                            @case('R')
                                                                <div class="alert alert-danger" role="alert">
                                                                    Rejected
                                                                </div>
                                                                @break
                                                            @case('CNA')
                                                                <div class="alert alert-warning" role="alert">
                                                                    Cancelled because of last approver is rejected
                                                                </div>
                                                                @break
                                                            @default
                                                                Unknown Status
                                                        @endswitch
                                                    
                                                    </label>
                                                        
                                                    @endif
                                                    
                                                    
                                                    {{-- <br> --}}
                                                    {{-- <div class="d-flex gap-0">
                                                        <button type="button" class="btn btn-outline-success flex-fill">Approved</button>
                                                        <button type="button" class="btn btn-outline-danger flex-fill">Reject</button>
                                                    </div> --}}
                                                </div>
                                                @endforeach
                                        </div>
                                        @endif
                                        
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (!$asset_issuance->is_finalized)
        <div class="modal fade" id="EmployeeInfo" tabindex="-1" role="dialog" aria-labelledby="EmployeeInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="EmployeeInfoLabel">
                            Other Information
                        </h5>
                    </div>
                    
                    <div class="modal-body">
                            <input type="hidden" name="issuance_detl_id" id="issuance_detl_id" value="">
                            <div class="row">
                                <hr>
                                <h5>Software Information</h5>
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">OS Version</label><br>
                                        <span class="fw-bold" id="osVersion" ></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">OS Patch version</label>
                                        <br>
                                        <input type="text" class="form-control" id="os_patch_version"  value="">
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Processor Model </label>
                                        <br>
                                        <span class="fw-bold" id="processor_model"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Disk Details</label>
                                        <br>
                                        <span class="fw-bold" id="disk_details"></span>
                                    </div>
                            </div>
        
                            <div class="row">
                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label" >Ram Details</label>
                                    <br>
                                    <span class="fw-bold" id="ram_details"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Utilities</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_ms" name="is_ms">
                                        <label class="form-check-label" for="temporary">MS Office</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_hcs" name="is_hcs">
                                        <label class="form-check-label" for="permanent">HCS</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_ada" name="is_ada">
                                        <label class="form-check-label" for="permanent">Adobe Acrobat</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_no" name="is_no">
                                        <label class="form-check-label" for="permanent">Netsuite Oracle</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    {{-- <label class="form-label">Utilities</label> --}}
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_acr" name="is_acr">
                                        <label class="form-check-label" for="temporary">Acrobat Reader</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Others</label>
                                    <div class="form-check">
                                        {{-- <label class="form-check-label" for="temporary">Acrobat Reader</label> --}}
                                        <textarea class="form-control" id="other_text" name="other_text" placeholder="Other"></textarea>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Peripherals</label>
                                            <input type="text" class="form-control" id="pheri_1" name="pheri_1" value="">
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <hr>
                                <h5>Network Resources Privelage</h5>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Internet</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intfull" name="is_intfull">
                                        <label class="form-check-label" for="temporary">Full</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intlimited" name="is_intlimited">
                                        <label class="form-check-label" for="permanent">Limited</label> <input type="text" class="form-control" id="intlimited_detl" name="intlimited_detl"  value="">
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intnone" name="is_intnone">
                                        <label class="form-check-label" for="permanent">None</label>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">IP Address assignment</label>
                                        <input type="text" class="form-control" id="intip_add" name="intip_add" value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Subnet</label>
                                        <input type="text" class="form-control" id="intsub_net" name="intsub_net" value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Mac Address</label>
                                        <input type="text" class="form-control" id="intmac_add" name="intmac_add" value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Network group</label>
                                        <input type="text" class="form-control" id="intnet_group" name="intnet_group"   value="">
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label"></label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intvoip" name="is_intvoip">
                                        <label class="form-check-label" for="temporary">VOIP ext</label><input type="text" class="form-control" id="is_intvoip_detls" name="is_intvoip_detls">
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intpbx" name="is_intpbx">
                                        <label class="form-check-label" for="temporary">PBX ext</label><input type="text" class="form-control" id="is_intpbx_detls" name="is_intpbx_detls">
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="temporary">WIFI SSID</label>
                                        <input type="text" class="form-control" id="intwifi_ssid" name="intwifi_ssid" value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Drive(s)</label>
                                        <input type="text" class="form-control" id="intshared_drive" name="intshared_drive"  value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Printer(s)</label>
                                        <input type="text" class="form-control" id="intshared_print" name="intshared_print"   value="">
                                    </div>
                                </div>
                            </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="save_data()">save</button>
                        <button type="button" class="btn btn-danger" onclick="close_modal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @else

        <div class="modal fade" id="EmployeeInfo_view" tabindex="-1" role="dialog" aria-labelledby="EmployeeInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="EmployeeInfoLabel">
                            Other Information
                        </h5>
                    </div>
                    
                    <div class="modal-body">
                            <input type="hidden" name="issuance_detl_id" id="issuance_detl_id" value="">
                            <div class="row">
                                <hr>
                                <h5>Software Information</h5>
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">OS Version</label><br>
                                        <span class="fw-bold" id="osVersion_vew" ></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">OS Patch version</label>
                                        <br>
                                        <input type="text" class="form-control" id="os_patch_version"  value="" disabled readonly>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Processor Model </label>
                                        <br>
                                        <span class="fw-bold" id="processor_model_vew"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Disk Details</label>
                                        <br>
                                        <span class="fw-bold" id="disk_details_vew"></span>
                                    </div>
                            </div>
        
                            <div class="row">
                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label" >Ram Details</label>
                                    <br>
                                    <span class="fw-bold" id="ram_details_vew"></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Utilities</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_ms" name="is_ms"  disabled readonly>
                                        <label class="form-check-label" for="temporary">MS Office</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_hcs" name="is_hcs"  disabled readonly>
                                        <label class="form-check-label" for="permanent">HCS</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_ada" name="is_ada"  disabled readonly>
                                        <label class="form-check-label" for="permanent">Adobe Acrobat</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_no" name="is_no"  disabled readonly>
                                        <label class="form-check-label" for="permanent">Netsuite Oracle</label>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    {{-- <label class="form-label">Utilities</label> --}}
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_acr" name="is_acr"  disabled readonly>
                                        <label class="form-check-label" for="temporary">Acrobat Reader</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Others</label>
                                    <div class="form-check">
                                        {{-- <label class="form-check-label" for="temporary">Acrobat Reader</label> --}}
                                        <textarea class="form-control" id="other_text" name="other_text" placeholder="Other"  disabled readonly></textarea>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label class="form-label">Peripherals</label>
                                            <input type="text" class="form-control" id="pheri_1" name="pheri_1" value=""  disabled readonly>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <hr>
                                <h5>Network Resources Privelage</h5>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Internet</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intfull" name="is_intfull"  disabled readonly>
                                        <label class="form-check-label" for="temporary">Full</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intlimited" name="is_intlimited"  disabled readonly>
                                        <label class="form-check-label" for="permanent">Limited</label> <input type="text" class="form-control" id="intlimited_detl" name="intlimited_detl"  value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intnone" name="is_intnone"  disabled readonly>
                                        <label class="form-check-label" for="permanent">None</label>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">IP Address assignment</label>
                                        <input type="text" class="form-control" id="intip_add" name="intip_add" value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Subnet</label>
                                        <input type="text" class="form-control" id="intsub_net" name="intsub_net" value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Mac Address</label>
                                        <input type="text" class="form-control" id="intmac_add" name="intmac_add" value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="permanent">Network group</label>
                                        <input type="text" class="form-control" id="intnet_group" name="intnet_group"   value=""  disabled readonly>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label"></label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intvoip" name="is_intvoip"  disabled readonly>
                                        <label class="form-check-label" for="temporary">VOIP ext</label><input type="text" class="form-control" id="is_intvoip_detls" name="is_intvoip_detls"  disabled readonly>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intpbx" name="is_intpbx"  disabled readonly>
                                        <label class="form-check-label" for="temporary">PBX ext</label><input type="text" class="form-control" id="is_intpbx_detls" name="is_intpbx_detls"  disabled readonly>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="temporary">WIFI SSID</label>
                                        <input type="text" class="form-control" id="intwifi_ssid" name="intwifi_ssid" value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Drive(s)</label>
                                        <input type="text" class="form-control" id="intshared_drive" name="intshared_drive"  value=""  disabled readonly>
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Printer(s)</label>
                                        <input type="text" class="form-control" id="intshared_print" name="intshared_print"   value=""  disabled readonly>
                                    </div>
                                </div>
                            </div>
                    </div>
        
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-success" onclick="save_data()">save</button> --}}
                        <button type="button" class="btn btn-danger" onclick="close_modal2()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif


        <script>

            jQuery.ajaxSetup({
                async: false
            });

            function save_data(){
                Swal.showLoading();
                var issuance_detl_id = document.getElementById("issuance_detl_id").value;
                var os_patch_version = document.getElementById("os_patch_version").value;
                var is_ms = document.getElementById("is_ms").checked;
                var is_hcs = document.getElementById("is_hcs").checked;
                var is_ada = document.getElementById("is_ada").checked;
                var is_no = document.getElementById("is_no").checked;
                var is_acr = document.getElementById("is_acr").checked;
                var other_text = document.getElementById("other_text").value;
                var pheri_1 = document.getElementById("pheri_1").value;
                var is_intfull = document.getElementById("is_intfull").checked;
                var is_intlimited = document.getElementById("is_intlimited").checked;
                var intlimited_detl = document.getElementById("intlimited_detl").value;
                var is_intnone = document.getElementById("is_intnone").checked;
                var intip_add = document.getElementById("intip_add").value;
                var intsub_net = document.getElementById("intsub_net").value;
                var intmac_add = document.getElementById("intmac_add").value;
                var intnet_group = document.getElementById("intnet_group").value;
                var is_intvoip = document.getElementById("is_intvoip").checked;
                var is_intpbx = document.getElementById("is_intpbx").checked;
                var intwifi_ssid = document.getElementById("intwifi_ssid").value;
                var intshared_drive = document.getElementById("intshared_drive").value;
                var intshared_print = document.getElementById("intshared_print").value;
                var is_intvoip_detls = document.getElementById("is_intvoip_detls").value;
                var is_intpbx_detls = document.getElementById("is_intpbx_detls").value;

                $.ajax({
                    type: "POST",
                    url: "/AssetAssign/update_detl",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "issuance_detl_id": issuance_detl_id,
                        "os_patch_version": os_patch_version,
                        "is_ms": is_ms,
                        "is_hcs": is_hcs,
                        "is_ada": is_ada,
                        "is_no": is_no,
                        "is_acr": is_acr,
                        "other_text": other_text,
                        "pheri_1": pheri_1,
                        "is_intfull": is_intfull,
                        "is_intlimited": is_intlimited,
                        "intlimited_detl": intlimited_detl,
                        "is_intnone": is_intnone,
                        "intip_add": intip_add,
                        "intsub_net": intsub_net,
                        "intmac_add": intmac_add,
                        "intnet_group": intnet_group,
                        "is_intvoip": is_intvoip,
                        "is_intvoip_detls": is_intvoip_detls,
                        "is_intpbx": is_intpbx,
                        "is_intpbx_detls": is_intpbx_detls,
                        "intwifi_ssid": intwifi_ssid,
                        "intshared_drive": intshared_drive,
                        "intshared_print": intshared_print
                    },
                    success: function (response) {
                        if(response.status == "success"){
                            toastr.success("Data Saved");
                            $("#EmployeeInfo").modal("hide");
                            Swal.close();
                        }
                    },
                    error: function (error) {
                        console.log(error)
                        toastr.error("Error: " + error.responseJSON.message);
                    }
                });
            }
            function getTheEmployee(){
                const emp_id = $('#empp_no').val();


                $.ajax({
                    type: "POST",
                    url: "/Employee_DB/getEmployee",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: emp_id
                    },
                    success: function (response) {
                        document.getElementById("name_data").value = response.first_name + " " + response.last_name
                        document.getElementById("position_data").value = "NULL";
                        document.getElementById("company_data").value = response.company.name;
                        document.getElementById("department_data").value = response.department.name;
                        getLocation(response.company.id, response.department.id);
                    }
                });
            }

            function getLocation(company, department){
                $.ajax({
                        url: "/Location/getLocation",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            company_id: company,
                            department_id: department
                        },
                        success: function (response) {
                            let data_str = `<option value="" disabled selected>Select Location</option>`;
                            // console.log(response)
                            response.forEach(element => {
                                data_str += `<option value="${element.id}">${element.name}</option>`;
                            });
                            $('#location_id').html(data_str);
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                        }
                    });
            }
            function getSave_detl(i, asset_id){
                var main_id = document.getElementById("issuance_id").value;
                $.ajax({
                    type: "POST",
                    url: "/AssetAssign/detl/"+main_id,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "asset_id": asset_id,
                        "issuance_main_id": main_id
                    },
                    success: function (response) {
                        console.log(response)
                        var button = $('#data_save_'+i);
                        var button_remove = $('#data_remove_'+i);
                        button.replaceWith(`<button type="button" class="btn btn-outline-primary viewDetails"
                        data-details_id="`+ response.data.id+`"
                        data-os_version="`+response.data.os_patch_ver +`"

                        data-isMSoffice="`+response.data.os_patch_ver +`"
                        data-isHCS="`+response.data.isHCS +`"
                        data-isNetSuite="`+response.data.isNetSuite +`"
                        data-isAcrobat_r="`+response.data.isAcrobat_r +`"
                        data-isAcrobat_a="`+response.data.isAcrobat_a +`"
                        data-others="`+response.data.others +`"
                        data-pheripherals="`+response.data.peripherals +`"
                        data-int_isfull="`+response.data.int_isfull +`"
                        data-int_islimited="`+response.data.int_islimited +`"
                        data-int_isNone="`+response.data.int_isNone +`"
                        data-int_isvoip_ext="`+response.data.int_isvoip_ext +`"
                        data-int_isvoip_ext_detls="`+response.data.int_isvoip_ext_detls +`"
                        data-int_ispbx_ext="`+response.data.int_ispbx_ext +`"
                        data-int_ispbx_ext_detls="`+response.data.int_ispbx_ext_detls +`"
                        data-int_wifi_ssid="`+response.data.int_wifi_ssid +`"
                        data-int_shared_drive="`+response.data.int_shared_drives +`"
                        data-int_shared_printer="`+response.data.int_shared_printers +`"
                        data-int_ip_assign="`+response.data.int_ip_assign +`"
                        data-int_subnet="`+response.data.int_subnet +`"
                        data-int_mac_add="`+response.data.int_mac_address +`"
                        data-int_net_group="`+response.data.int_network_group +`"

                        onclick="getdataall( `+response.data.id+`, `+asset_id+`)">Details</button>`);
                        button_remove.replaceWith(`<button type="button" class="btn btn-outline-danger viewDetails" onclick="getDelete(`+response.data.id+`)" >Delete</button>`);
                            // Add a new row to allow further inputs
                        // addNewRow1(i);
                        // location.reload();

                        Swal.close();
                    }
                });
            }

            function getAsset(id) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '/AssetAssign/getAssetById',
                        method: 'POST',
                        data: { 
                            "_token": '{{ csrf_token() }}',
                            "asset_iddata": id
                        },
                        success: function (response) {
                            if (response.status === "success") {
                                if (response.data === null) {
                                    Swal.fire({
                                        title: "Asset not Found",
                                        icon: "error"
                                    });
                                    resolve(null); // Resolve with null if no data is found
                                } else {
                                    resolve(response.data); // Resolve with actual data
                                }
                            } else {
                                reject("Error: Invalid response status");
                            }
                        },
                        error: function (error) {
                            reject(error); // Reject in case of error
                        }
                    });
                });
            }

            // Usage with `await`
            async function fetchAsset(id) {
                try {
                    let assetData = await getAsset(id); // Replace 123 with the actual asset ID
                    return assetData;
                } catch (error) {
                    console.error(error);
                }
            }

            function getDelete(id){
                Swal.showLoading();
                $.ajax({
                    type: "DELETE",
                    url: "/AssetAssign/getDelete",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "detl_id": id
                    },
                    success: function (response) {
                        if(response.status == "success"){
                            toastr.success("Asset Deleted");
                            Swal.close();
                            location.reload();
                        }
                    },
                    error: function (error) {
                        console.log(error)
                        Swal.close();
                        toastr.error("Error: " + error.responseJSON.message);
                    }
                });
            }


            function addNewRow1(rowId) {
               
                    var rowId = parseInt($('#last_count_data').val());
                    var rowCount = parseInt(rowId) // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false"></td>
                            <td><span class="text-center" id="category_${newRowId}"></span></td>
                            <td><span class="text-center" id="model_${newRowId}"></span></td>
                            <td><span class="text-center" id="serial_${newRowId}"></span></td>
                            <td>
                                <button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                                <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>
                            </td>
                        </tr>
                `;
                $('#example3 tbody').append(newRow);
                $('#last_count_data').val(newRowId);
                $('#data_' + newRowId).focus();
            }



            $(document).ready(function () {
                // var table = $('#example3').DataTable();

                function addNewRow() {
                    
                    var rowCount = parseInt($('#last_count_data').val()); // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false"></td>
                            <td><span class="text-center" id="category_${newRowId}"></span></td>
                            <td><span class="text-center" id="model_${newRowId}"></span></td>
                            <td><span class="text-center" id="serial_${newRowId}"></span></td>
                            <td>
                                <button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                                <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#example3 tbody').append(newRow);
                    $('#last_count_data').val(newRowId)
                    $('#data_' + newRowId).focus();
                }

                    $('#example3 tbody').on('keypress', 'input', function (event) {
                        if (event.which === 13) {  // 13 = Enter key
                            event.preventDefault();  // Prevent form submission

                            var barcodeValue = $(this).val();  // Get the barcode value
                            var rowId = $(this).attr('data-id');  // Get the row's data-id

                            console.log("Scanned Barcode:", barcodeValue, "Row ID:", rowId);

                            $.ajax({
                                type: "POST",
                                url: "/AssetAssign/getAsset",
                                data: {
                                    "_token": '{{ csrf_token() }}',
                                    "asset_id": barcodeValue
                                },
                                success: function (response) {
                                    if(response.status == "success"){
                                        Swal.showLoading();
                                        if(response.data == null){
                                            Swal.close();
                                            Swal.fire({
                                                title: "Asset not Found",
                                                icon: "error"
                                            });
                                            document.getElementById("data_"+rowId).value = "";
                                        }
                                        
                                        var text_data = $('#data_'+rowId);
                                        text_data.replaceWith(`<span class="text-center" id="data_${rowId}">`+response.data.asset_id+`</span>`);
                                        // document.getElementById("data_"+rowId).value = response.data.asset_id
                                        document.getElementById("category_"+rowId).innerHTML = response.data.category_data.name
                                        document.getElementById("model_"+rowId).innerHTML = response.data.model_no
                                        document.getElementById("serial_"+rowId).innerHTML = response.data.serial_number
                                        getSave_detl(rowId, response.data.id);
                                        
                                    }
                                }
                            });
                            $(this).closest('tr').next().find('input').focus();
                            // You can now process the barcode value (e.g., send via AJAX, update table, etc.)
                        }
                    });

                    // Handle "Save" button click
                    $('#example3 tbody').on('click', '.saveRow', function () {
                        var row = $(this).closest('tr'); // Get the row
                        var inputData = row.find('input').val(); // Get input value
                        var button = $(this); // Reference to the button
                        // console.log(inputData)
                        if (inputData.trim() === "") {
                            alert("Please enter a value before saving.");
                            return;
                        }
                        var main_id = document.getElementById("issuance_id").value;
                        // Simulate AJAX request to save data
                        Swal.showLoading();
                        $.ajax({
                            url: '/AssetAssign/getAsset', // Replace with your actual API endpoint
                            method: 'POST',
                            data: { 
                                "_token": '{{ csrf_token() }}',
                                "asset_id": inputData
                            },
                            success: function (response) {
                                if(response.status == "success"){
                                    var rowCount2 = parseInt($('#last_count_data').val());
                                    var intCurrent = rowCount2;
                                    console.log("inp",rowCount2 + 1)
                                        Swal.showLoading();
                                        if(response.data == null){
                                            Swal.close();
                                            Swal.fire({
                                                title: "Asset not Found",
                                                icon: "error"
                                            });
                                            document.getElementById("data_"+intCurrent).value = "";
                                        }
                                        
                                        var text_data = $('#data_'+intCurrent);
                                        text_data.replaceWith(`<span class="text-center" id="data_${intCurrent}">`+response.data.asset_id+`</span>`);
                                        // document.getElementById("data_"+rowId).value = response.data.asset_id
                                        document.getElementById("category_"+intCurrent).innerHTML = response.data.category_data.name
                                        document.getElementById("model_"+intCurrent).innerHTML = response.data.model_no
                                        document.getElementById("serial_"+intCurrent).innerHTML = response.data.serial_number
                                        getSave_detl(intCurrent, response.data.id);
                                        addNewRow()
                                        
                                    }
                            },
                            error: function (error) {
                            }
                        });
                    });

                    // Handle "Remove" button click
                    $('#example3 tbody').on('click', '.removeRow', function () {
                        var table = $('#example3').DataTable();
                        table.row($(this).closest('tr')).remove().draw(false);
                    });

                    // Initial row
                    addNewRow();
                    
            });


            function clearall(){
                document.getElementById("os_patch_version").value = "";
                document.getElementById("is_ms").checked = false;
                document.getElementById("is_hcs").checked = false;
                document.getElementById("is_ada").checked = false;
                document.getElementById("is_no").checked = false;
                document.getElementById("is_acr").checked = false;
                document.getElementById("other_text").value = "";
                document.getElementById("pheri_1").value = "";
                document.getElementById("is_intfull").checked = false;
                document.getElementById("is_intlimited").checked = false;
                document.getElementById("intlimited_detl").value = "";
                document.getElementById("is_intnone").checked = false;
                document.getElementById("intip_add").value = "";
                document.getElementById("intsub_net").value = "";
                document.getElementById("intmac_add").value = "";
                document.getElementById("intnet_group").value = "";
                document.getElementById("is_intvoip").checked = false;
                document.getElementById("is_intvoip_detls").value = "";
                document.getElementById("is_intpbx").checked = false;
                document.getElementById("is_intpbx_detls").value = "";
                document.getElementById("intwifi_ssid").value = "";
                document.getElementById("intshared_drive").value = "";
                document.getElementById("intshared_print").value = "";
            }

            function getdataall(detl_id, asset_id){
                try {
                    // const data_asset = fetchAsset(asset_id);
                    Swal.showLoading();
                    fetchAsset(asset_id)
                    .then((data)=>{
                        Swal.close();
                        console.log(data)
                        document.getElementById("osVersion").innerHTML = data.os_details
                        document.getElementById("processor_model").innerHTML = data.processor_model
                        document.getElementById("disk_details").innerHTML = data.desk_details
                        document.getElementById("ram_details").innerHTML = data.ram_details
                        document.getElementById("issuance_detl_id").value = detl_id;
                        // clearall();
                        // let osVersion = $("#save_0").attr("data-os_version");
                        // let isMSoffice = $("#save_0").attr("data-isMSoffice");
                        // let isHCS = $("#save_0").attr("data-isHCS");
                        // let isNetSuite = $("#save_0").attr("data-isNetSuite");
                        // let isAcrobat_r = $("#save_0").attr("data-isAcrobat_r");
                        // let isAcrobat_a = $("#save_0").attr("data-isAcrobat_a");
                        // let others = $("#save_0").attr("data-others");
                        // let peripherals = $("#save_0").attr("data-pheripherals");
                        // let int_isfull = $("#save_0").attr("data-int_isfull");
                        // let int_islimited = $("#save_0").attr("data-int_islimited");
                        // let int_isNone = $("#save_0").attr("data-int_isNone");
                        // let int_isvoip_ext = $("#save_0").attr("data-int_isvoip_ext");
                        // let int_isvoip_ext_detls = $("#save_0").attr("data-int_isvoip_ext_detls");
                        // let int_ispbx_ext = $("#save_0").attr("data-int_ispbx_ext");
                        // let int_ispbx_ext_detls = $("#save_0").attr("data-int_ispbx_ext_detls");
                        // let int_wifi_ssid = $("#save_0").attr("data-int_wifi_ssid");
                        // let int_shared_drive = $("#save_0").attr("data-int_shared_drive");
                        // let int_shared_printer = $("#save_0").attr("data-int_shared_printer");
                        // let int_ip_assign = $("#save_0").attr("data-int_ip_assign");
                        // let int_subnet = $("#save_0").attr("data-int_subnet");
                        // let int_mac_add = $("#save_0").attr("data-int_mac_add");
                        // let int_net_group = $("#save_0").attr("data-int_net_group");

                        // document.getElementById("os_patch_version").value = osVersion;
                        // document.getElementById("is_ms").checked = isMSoffice == 1 ? true : false;
                        // document.getElementById("is_hcs").checked = isHCS == 1 ? true : false;
                        // document.getElementById("is_ada").checked = isAcrobat_a == 1 ? true : false;
                        // document.getElementById("is_no").checked = isNetSuite == 1 ? true : false;
                        // document.getElementById("is_acr").checked = isAcrobat_r == 1 ? true : false;
                        // document.getElementById("other_text").value = others;
                        // document.getElementById("pheri_1").value = peripherals;
                        // document.getElementById("is_intfull").checked = int_isfull == 1 ? true : false;
                        // document.getElementById("is_intlimited").checked = int_islimited == 1 ? true : false;
                        // document.getElementById("intlimited_detl").value = int_islimited == 1 ? int_islimited : "";
                        // document.getElementById("is_intnone").checked = int_isNone == 1 ? true : false;
                        // document.getElementById("intip_add").value = int_ip_assign;
                        // document.getElementById("intsub_net").value = int_subnet;
                        // document.getElementById("intmac_add").value = int_mac_add;
                        // document.getElementById("intnet_group").value = int_net_group;
                        // document.getElementById("is_intvoip").checked = int_isvoip_ext == 1 ? true : false;
                        // document.getElementById("is_intvoip_detls").value = int_isvoip_ext_detls;
                        // document.getElementById("is_intpbx").checked = int_ispbx_ext == 1 ? true : false;
                        // document.getElementById("is_intpbx_detls").value = int_ispbx_ext_detls;
                        // document.getElementById("intwifi_ssid").value = int_wifi_ssid;
                        // document.getElementById("intshared_drive").value = int_shared_drive;
                        // document.getElementById("intshared_print").value = int_shared_printer;

                        // console.log(osVersion)
                        $("#EmployeeInfo").modal("show");
                    })
                } catch (error) {
                    toastr.error("Error: " + "Asset not found");
                }
            }


            function getdataall_view(detl_id, asset_id){
                try {
                    // const data_asset = fetchAsset(asset_id);
                    Swal.showLoading();
                    fetchAsset(asset_id)
                    .then((data)=>{
                        Swal.close();
                        console.log(data)
                        document.getElementById("osVersion_vew").innerHTML = data.os_details
                        document.getElementById("processor_model_vew").innerHTML = data.processor_model
                        document.getElementById("disk_details_vew").innerHTML = data.desk_details
                        document.getElementById("ram_details_vew").innerHTML = data.ram_details
                        $("#EmployeeInfo_view").modal("show");
                    })
                } catch (error) {
                    toastr.error("Error: " + "Asset not found");
                }
            }

            $(document).on("click", "#save_0", function () {
                let osVersion = $(this).attr("data-os_version");
                let isMSoffice = $(this).attr("data-isMSoffice");
                let isHCS = $(this).attr("data-isHCS");
                let isNetSuite = $(this).attr("data-isNetSuite");
                let isAcrobat_r = $(this).attr("data-isAcrobat_r");
                let isAcrobat_a = $(this).attr("data-isAcrobat_a");
                let others = $(this).attr("data-others");
                let peripherals = $(this).attr("data-pheripherals");
                let int_isfull = $(this).attr("data-int_isfull");
                let int_islimited = $(this).attr("data-int_islimited");
                let int_isNone = $(this).attr("data-int_isNone");
                let int_isvoip_ext = $(this).attr("data-int_isvoip_ext");
                let int_isvoip_ext_detls = $(this).attr("data-int_isvoip_ext_detls");
                let int_ispbx_ext = $(this).attr("data-int_ispbx_ext");
                let int_ispbx_ext_detls = $(this).attr("data-int_ispbx_ext_detls");
                let int_wifi_ssid = $(this).attr("data-int_wifi_ssid");
                let int_shared_drive = $(this).attr("data-int_shared_drive");
                let int_shared_printer = $(this).attr("data-int_shared_printer");
                let int_ip_assign = $(this).attr("data-int_ip_assign");
                let int_subnet = $(this).attr("data-int_subnet");
                let int_mac_add = $(this).attr("data-int_mac_add");
                let int_net_group = $(this).attr("data-int_net_group");


                document.getElementById("os_patch_version").value = osVersion;
                document.getElementById("is_ms").checked = isMSoffice == 1 ? true : false;
                document.getElementById("is_hcs").checked = isHCS == 1 ? true : false;
                document.getElementById("is_ada").checked = isAcrobat_a == 1 ? true : false;
                document.getElementById("is_no").checked = isNetSuite == 1 ? true : false;
                document.getElementById("is_acr").checked = isAcrobat_r == 1 ? true : false;
                document.getElementById("other_text").value = others;
                document.getElementById("pheri_1").value = peripherals;
                document.getElementById("is_intfull").checked = int_isfull == 1 ? true : false;
                document.getElementById("is_intlimited").checked = int_islimited == 1 ? true : false;
                document.getElementById("intlimited_detl").value = int_islimited == 1 ? int_islimited : "";
                document.getElementById("is_intnone").checked = int_isNone == 1 ? true : false;
                document.getElementById("intip_add").value = int_ip_assign;
                document.getElementById("intsub_net").value = int_subnet;
                document.getElementById("intmac_add").value = int_mac_add;
                document.getElementById("intnet_group").value = int_net_group;
                document.getElementById("is_intvoip").checked = int_isvoip_ext == 1 ? true : false;
                document.getElementById("is_intvoip_detls").value = int_isvoip_ext_detls;
                document.getElementById("is_intpbx").checked = int_ispbx_ext == 1 ? true : false;
                document.getElementById("is_intpbx_detls").value = int_ispbx_ext_detls;
                document.getElementById("intwifi_ssid").value = int_wifi_ssid;
                document.getElementById("intshared_drive").value = int_shared_drive;
                document.getElementById("intshared_print").value = int_shared_printer;
            });

            
            $(document).on("click", "#save_0_view", function () {
                let osVersion = $(this).attr("data-os_version_view");
                let isMSoffice = $(this).attr("data-isMSoffice");
                let isHCS = $(this).attr("data-isHCS");
                let isNetSuite = $(this).attr("data-isNetSuite");
                let isAcrobat_r = $(this).attr("data-isAcrobat_r");
                let isAcrobat_a = $(this).attr("data-isAcrobat_a");
                let others = $(this).attr("data-others");
                let peripherals = $(this).attr("data-pheripherals");
                let int_isfull = $(this).attr("data-int_isfull");
                let int_islimited = $(this).attr("data-int_islimited");
                let int_isNone = $(this).attr("data-int_isNone");
                let int_isvoip_ext = $(this).attr("data-int_isvoip_ext");
                let int_isvoip_ext_detls = $(this).attr("data-int_isvoip_ext_detls");
                let int_ispbx_ext = $(this).attr("data-int_ispbx_ext");
                let int_ispbx_ext_detls = $(this).attr("data-int_ispbx_ext_detls");
                let int_wifi_ssid = $(this).attr("data-int_wifi_ssid");
                let int_shared_drive = $(this).attr("data-int_shared_drive");
                let int_shared_printer = $(this).attr("data-int_shared_printer");
                let int_ip_assign = $(this).attr("data-int_ip_assign");
                let int_subnet = $(this).attr("data-int_subnet");
                let int_mac_add = $(this).attr("data-int_mac_add");
                let int_net_group = $(this).attr("data-int_net_group");


                document.getElementById("os_patch_version").value = osVersion;
                document.getElementById("is_ms").checked = isMSoffice == 1 ? true : false;
                document.getElementById("is_hcs").checked = isHCS == 1 ? true : false;
                document.getElementById("is_ada").checked = isAcrobat_a == 1 ? true : false;
                document.getElementById("is_no").checked = isNetSuite == 1 ? true : false;
                document.getElementById("is_acr").checked = isAcrobat_r == 1 ? true : false;
                document.getElementById("other_text").value = others;
                document.getElementById("pheri_1").value = peripherals;
                document.getElementById("is_intfull").checked = int_isfull == 1 ? true : false;
                document.getElementById("is_intlimited").checked = int_islimited == 1 ? true : false;
                document.getElementById("intlimited_detl").value = int_islimited == 1 ? int_islimited : "";
                document.getElementById("is_intnone").checked = int_isNone == 1 ? true : false;
                document.getElementById("intip_add").value = int_ip_assign;
                document.getElementById("intsub_net").value = int_subnet;
                document.getElementById("intmac_add").value = int_mac_add;
                document.getElementById("intnet_group").value = int_net_group;
                document.getElementById("is_intvoip").checked = int_isvoip_ext == 1 ? true : false;
                document.getElementById("is_intvoip_detls").value = int_isvoip_ext_detls;
                document.getElementById("is_intpbx").checked = int_ispbx_ext == 1 ? true : false;
                document.getElementById("is_intpbx_detls").value = int_ispbx_ext_detls;
                document.getElementById("intwifi_ssid").value = int_wifi_ssid;
                document.getElementById("intshared_drive").value = int_shared_drive;
                document.getElementById("intshared_print").value = int_shared_printer;
            });

            
            $(document).on("click", "#btn_approved_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let asset_iss_id = $(this).attr("data-asset_iss_id");
                // Swal.showLoading();

                Swal.fire({
                    title: "Do you want to approved issuance?",
                    text: "Once approved, you will not be able to make changes and send the issuance to the next approvers",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Aprroved",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    // Swal.close();
                    // Swal.showLoading();
                    Swal.fire({
                        title: "Processing...",
                        text: "Please wait while the issuance is being approved.",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            var id = document.getElementById("issuance_id").value;
                            $.ajax({
                                type: "POST",
                                url: "/AssetAssign/approvers",
                                data: {
                                    "_token": '{{ csrf_token() }}',
                                    "appr_id": appr_id,
                                    "user_id": user_id,
                                    "status": status,
                                    "asset_iss_id": asset_iss_id
                                },
                                success: function (response) {
                                    
                                    toastr.success(response.message);
                                    location.reload();
                                },
                                error: function (error) {
                                    console.log(error)
                                    toastr.error("Error: " + error.responseJSON.message);
                                }
                            });
                        }
                    });
                    
                    // $.ajax({
                    //     type: "POST",
                    //     url: "/AssetAssign/approvers",
                    //     data: {
                    //         "_token": '{{ csrf_token() }}',
                    //         "appr_id": appr_id,
                    //         "user_id": user_id,
                    //         "status": status,
                    //         "asset_iss_id": asset_iss_id
                    //     },
                    //     success: function (response) {
                    //         Swal.close();
                    //         toastr.success(response.message);
                    //         location.reload();
                    //     },
                    //     error: function (error) {
                    //         console.log(error)
                    //         toastr.error("Error: " + error.responseJSON.message);
                    //     }
                    // });
                    
                    // Swal.fire("Saved!", "", "success");
                    
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
                });
                
            });

            $(document).on("click", "#btn_reject_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let asset_iss_id = $(this).attr("data-asset_iss_id");
                

                Swal.fire({
                    title: "Do you want to Disaprroved issuance?",
                    text: "Once Disaprroved, you will not be able to make changes.",
                    icon: "error",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Disaprroved",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var id = document.getElementById("issuance_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/AssetAssign/approvers",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "appr_id": appr_id,
                            "user_id": user_id,
                            "status": status,
                            "asset_iss_id": asset_iss_id
                        },
                        success: function (response) {
                            swal.close();
                            toastr.success(response.message);
                            location.reload();
                        },
                        error: function (error) {
                            console.log(error)
                            toastr.error("Error: " + error.responseJSON.message);
                        }
                    });
                    
                    // Swal.fire("Saved!", "", "success");
                    
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
                });
                
            });
            


            function final_data(){
                Swal.fire({
                    title: "Do you want to finalized the issuance?",
                    text: "Once finalized, you will not be able to make changes and send the issuance will send for approval",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Finalize",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var id = document.getElementById("issuance_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/AssetAssign/finalize",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "id_issuance_main": id
                        },
                        success: function (response) {
                            swal.close();
                            toastr.success(response.message);
                            location.reload();
                        },
                        error: function (error) {
                            console.log(error)
                            toastr.error("Error: " + error.responseJSON.message);
                        }
                    });
                    
                    // Swal.fire("Saved!", "", "success");
                    
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
                });

            }

            function close_modal(){
                $("#EmployeeInfo").modal("hide");
            }
            function close_modal2(){
                $("#EmployeeInfo_view").modal("hide");
            }
        </script>
    
</x-app-layout>