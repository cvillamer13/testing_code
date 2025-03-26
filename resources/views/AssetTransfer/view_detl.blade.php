<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Transfer') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">View Asset Transfer</h4>
                        <div class="card-title col-6 text-end">
                            {{-- <a class="btn btn-rounded btn-info" id="scanned_start" href="./add">
                                Add Asset Transfer
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a> --}}
                        </div>
                    </div>

                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Asset Issuance No</label>
                                                    <input type="hidden" name="" class="form-control" value="{{ $data_view->from_issuance }}">
                                                    {{-- <a type="button" class="btn btn-info">find</a> --}}
                                                </div>
                                                {{-- <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="bttn_find"></label>
                                                    <br>
                                                    <a type="button" class="btn btn-info" id="bttn_find">Find</a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    @csrf
                                    <input type="hidden" name="issuance_id_show" id="issuance_id_show" value="{{ $data_view->id }}">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <h4>From</h4>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Asset Issuance No</label>
                                                    <input type="text" class="form-control" name="from_issuance_no" id="from_issuance_no" value="{{ $data_view->from_issuance }}" readonly disabled> 
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Assign Employee</label>
                                                    <input type="text" class="form-control" name="from_employee" id="from_employee" value="{{ $data_view->getEmployee->first_name . " " . $data_view->getEmployee->last_name }}" disabled readonly> 
                                                    <input type="hidden"  name="from_employee_id" id="from_employee_id"> 
                                                </div>
                                            </div>

        
                                            
                                            
                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Asset Details</label>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                {{-- <th></th> --}}
                                                                <th>Asset Tag</th>
                                                                <th>Description</th>
                                                                <th>Category</th>
                                                                <th>Model</th>
                                                                <th>Serial No.</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody  id="tbody_data">
                                                            @foreach ($data_view->assetDetails as $data)
                                                                <tr>
                                                                    <td>{{ $data->asset_id }}</td>
                                                                    <td>{{ $data->asset_description }}</td>
                                                                    <td>{{ $data->category_data->name }}</td>
                                                                    <td>{{ $data->model_no }}</td>
                                                                    <td>{{ $data->serial_number }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Transfer To Assign Employee</label>
                                                <input type="text" class="form-control" name="from_employee" id="from_employee" value="{{ $data_view->getEmployee_to->first_name . " " . $data_view->getEmployee_to->last_name }}" disabled readonly> 
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Report to</label>
                                                <input type="text" name="report_to" id="report_to" class="form-control" value="{{ $data_view->report_to }}" readonly disabled>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Location<span class="text-red">*</span></label>
                                                <input type="text" class="form-control" id="location_id" name="location_id"  value="{{ $data_view->getLocation_to->name }}" readonly disabled>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Deployment Type:</label>
                                                <p class="form-control-plaintext">
                                                    <b>{{ $data_view->deployment_type == 'temporary' ? 'For temporary' : 'For permanent' }}</b>
                                                </p>
                                            </div>

                                            <div class="col-md-9">
                                                <label class="form-label">Duration</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">From</label>
                                                        <p class="form-control-plaintext"><b>{{ $data_view->duration_from ?? ""  }}</b></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">To</label>
                                                        <p class="form-control-plaintext"><b>{{ $data_view->duration_to ?? ""  }}</b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Date Requested</label>
                                                <p class="form-control-plaintext"><b>{{ $data_view->date_requested ?? ""  }}</b></p>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Date Needed</label>
                                                <p class="form-control-plaintext"><b>{{ $data_view->date_needed ?? ""  }}</b></p>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label">Ref. RSS Ticket Numbers</label>
                                                <p class="form-control-plaintext"><b>{{ $data_view->ref_rss   }}</b></p>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <input type="hidden" name="selected_transfer" id="selected_transfer" value="">
                                    @if ($data_view->is_finalized)
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
                                                        <button type="button" class="btn btn-outline-success flex-fill" id="btn_approved_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="A" data-asset_iss_id="{{ $data_view->id }}">Approved</button>
                                                        <button type="button" class="btn btn-outline-danger flex-fill" id="btn_reject_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="R" data-asset_iss_id="{{ $data_view->id }}">Reject</button>
                                                        
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

                                            </div>
                                            @endforeach
                                    </div>
                                    @else
                                        <button type="button" class="btn btn-outline-primary mt-4 w-100" onclick="final_data()">Finalize</button>
                                    @endif
                                    

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>
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
            var id = document.getElementById("issuance_id_show").value;
            $.ajax({
                type: "POST",
                url: "/AssetTransfer/finalize",
                data: {
                    "_token": '{{ csrf_token() }}',
                    "transfer_id": id
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


    $(document).on("click", "#btn_approved_data", function () {
            let appr_id = $(this).attr("data-id");
            let user_id = $(this).attr("data-user_id");
            let status = $(this).attr("data-status");
            let asset_iss_id = $(this).attr("data-asset_iss_id");
                // Swal.showLoading();

                Swal.fire({
                    title: "Do you want to approved issuance?",
                    html: "Once approved, you will not be able to make changes and send the issuance to the next approvers",
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
                                // var id = document.getElementById("issuance_id").value;
                                $.ajax({
                                    type: "POST",
                                    url: "/AssetTransfer/approvers",
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
                        

                        
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
                
    });



</script>
</x-app-layout>