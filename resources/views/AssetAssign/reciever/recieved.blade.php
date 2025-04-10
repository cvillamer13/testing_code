<x-guest-layout>
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
                                        <a type="button" class="btn btn-outline-primary" href="/AssetAssign/gate_pass_rep/{{ $asset_issuance->id }}" target="_blank"><i class="las la-print"></i>Print Gatepass</a>
                                    </div>
                                    {{-- <div class="card-title col-6 text-end">
                                        <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                            Add Employee
                                            <span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                            </span>
                                        </a>
                                    </div> --}}
                                </div>
                                <input type="hidden" name="issuance_id" id="issuance_id" value="{{ $asset_issuance->id }}">
                                <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee_data->id }}">
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
                                                    @if ($asset_issuance->is_finalized || $asset_issuance->issued_by != session('user_email'))
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
                                        @if (!$asset_issuance->is_finalized && $asset_issuance->issued_by == session('user_email'))
                                            <button class="btn btn-primary mt-4 w-100" type="submit" onclick="final_data()">Finalize</button>
                                        @else
                                        <div class="row">
                                            <h5 class="card-title">Approvers</h5>
                                            
                                                @foreach ($issuance_status as $data)
                                                <div class="mb-3 col-sm-4 text-center">
                                                    <label for="employee_name" class="form-label"><b>{{  $data->user->name }}</b></label>
                                                    @if (!is_null($data->uid) > 0)
                                                        <p>uid: {{  $data->uid }}</p>
                                                    @endif

                                                    @if (!is_null($data->remarks) > 0)
                                                        <p>Reason: {{  $data->remarks }}</p>
                                                    @endif
                                                    {{-- <p>uid: {{  $data->uid }}</p> --}}
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
                                        {{-- <button class="btn btn-primary mt-4 w-100" type="submit" onclick="final_data()">Recieved</button> --}}

                                        @if ($asset_issuance->is_recieved)
                                        <div class="alert alert-success text-center" role="alert">
                                            Recieved By: {{ $employee_data->first_name . " " .  $employee_data->last_name  }} at {{ $asset_issuance->recieved_at }}
                                        </div>
                                    @else
                                        <button class="btn btn-primary mt-4 w-100" type="button" onclick="final_data()">Recieved</button>
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
                    <input type="hidden" id="approver_status" value="{{ $status }}">
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-success" onclick="save_data()">save</button> --}}
                        <button type="button" class="btn btn-danger" onclick="close_modal2()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endif


        <script>
            
            function final_data(){
                Swal.fire({
                    title: "Do you want to finalized the Asset issuance?",
                    text: "Once Recieved, you will not be able to make changes.",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Recieved",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var main_id = document.getElementById("issuance_id").value;
                    var emp_id = document.getElementById("employee_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/AssetAssign/received",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "issuance_id": main_id,
                            "emp_id" : emp_id
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


            
        </script>
    
</x-guest-layout>