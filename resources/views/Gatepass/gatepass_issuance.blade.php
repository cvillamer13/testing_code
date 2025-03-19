<x-app-layout>
    <x-slot name="header">
            {{ __('Gatepass (Issuance)') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Creation of Gatepass</h4>
                        <div class="card-title col-6 text-end">

                        </div>
                    </div>
                    @if ($data_gatepass->isRequest)
                    <form  method="POST" action="./to_finalize/{{ $data_gatepass->id }}" enctype="multipart/form-data">
                    @else
                    <form  method="POST" action="./{{ $data_gatepass->id }}" enctype="multipart/form-data">
                    @endif
                    {{-- <form  method="POST" action="./{{ $data_gatepass->id }}" enctype="multipart/form-data"> --}}
                        @csrf
                        <input type="hidden" name="gatepass_id_data" id="gatepass_id_data" value="{{ $data_gatepass->id }}">
                        <div class="card py-3 px-3">
                            <div class="row">
                                <label for="rev_no" class="form-label"><strong>Property Location</strong></label>
                                <div class="col-md-6  text-center border border-primary">
                                    <label for="rev_no" class="form-label"><strong>From</strong></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Company</label>
                                                <label for="rev_no" class="form-label"><b>{{ $from_location->company->name }}</b></label>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Department</label>
                                                <label for="rev_no" class="form-label"><b>{{ $from_location->department->name }}</b></label>
                                                </select>
                                            </div>
                                        </div>
    
    
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Location</label><br>
                                                <label for="rev_no" class="form-label"><b>{{ $from_location->name }}</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
    
                                <div class="col-md-6  text-center border border-primary">
                                    <label for="rev_no" class="form-label"><strong>To</strong></label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Company</label>
                                                <label for="rev_no" class="form-label"><b>{{ $to_location->company->name }}</b></label>
                                            </div>
                                        </div>
    
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Department</label>
                                                <label for="rev_no" class="form-label"><b>{{ $to_location->department->name }}</b></label>
                                            </div>
                                        </div>
    
    
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="rev_no" class="form-label">Location</label><br>
                                                <label for="rev_no" class="form-label"><b>{{ $to_location->name }}</b></label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <hr>
                            <label for="rev_no" class="form-label">
                                <strong style="color: red;">Note:</strong> This section will be automatically filled when you click <b>Create Gate Pass</b>.
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="rev_no" class="form-label"><strong>Date</strong></label>
                                    <div class="form-group mb-3">
                                        <input type="date" class="form-control" name="" id="" value="{{ $data_gatepass->date_issued }}" readonly>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <label for="rev_no" class="form-label"><strong>Gatepass No</strong></label>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" name="" id="" value="{{ $data_gatepass->gatepass_no }}" readonly>
                                    </div>
                                </div>
                            </div>
    
                            <hr>
    
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <td>Asset No</td>
                                        <td>Description</td>
                                        <td>Serial No</td>
                                        <td>Unit</td>
                                        <td>Pheriperals</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_issuance->assetDetails as $index => $asset)
                                        <tr>
                                            <td>{{ $asset->asset_id }}</td>
                                            <td>{{ $asset->asset_description }}</td>
                                            <td>{{ $asset->serial_number }}</td>
                                            <td>{{ $asset->unit_data ? $asset->unit_data->name : 'N/A' }}</td>
                                            <td>{{ $data_issuance->details[$index]->peripherals }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <h4 class="card-title col-6">Purpose</h4>
                            <textarea name="purpose_text" id="purpose_text" class="form-control" cols="15" rows="5" placeholder="" {{ $data_gatepass->isRequest ? 'readonly' : "" }}>{{ $data_gatepass->purpose }}</textarea>
                            @if ($data_gatepass->isRequest)
                                @if ($data_gatepass->is_finalized)
                                <div class="row">
                                    <h5 class="card-title">Approvers</h5>
                                    
                                        @foreach ($gatepasss_status as $data)
                                        <div class="mb-3 col-sm-4 text-center">
                                            <label for="employee_name" class="form-label"><b>{{  $data->user->name }}</b></label>
                                            @if (!is_null($data->uid) > 0)
                                                <p>uid: {{  $data->uid }}</p>
                                            @endif

                                            <br>

                                            @if ($data->user->id == Auth::user()->id && $data->status == 'P')
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-outline-success flex-fill" id="btn_approved_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="A" data-gatepass_id="{{ $data_gatepass->id }}">Approved</button>
                                                    <button type="button" class="btn btn-outline-danger flex-fill" id="btn_reject_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="R" data-gatepass_id="{{ $data_gatepass->id }}">Reject</button>
                                                    
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
                                @else
                                    <button class="btn btn-primary mt-4 w-100" type="button" id="to_finalize">Finalize</button>
                                @endif
                                
                            @else
                                <button class="btn btn-primary mt-4 w-100" type="submit">Create Gate Pass</button>
                            @endif
                            
                        </div>
                    </form>
                    
                    <input type="hidden" name="staus_data_link" id="staus_data_link" value="{{ $status }}">
                </div>
            </div>
        </div>

        <script>
            function getDepartment(company, department_html){
                var company_id = $('#'+company).val();
                $.ajax({
                    url: '/Location/getDepartment',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        company_id: company_id
                    },
                    success: function(data) {
                        let data_str = `<option value="" disabled selected>Select Department</option>`;

                        data.forEach(element => {
                            data_str += `<option value="${element.id}">${element.name}</option>`;
                        });
                    
                        $('#'+department_html).html(data_str);
                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }


            function getLocation(company, department, location_html){
                const company_id = $("#"+company).val();
                const department_id = $("#"+department).val();
                $.ajax({
                    url: "/Location/getLocation",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        company_id: company_id,
                        department_id: department_id
                    },
                    success: function (response) {
                        let data_str = `<option value="" disabled selected>Select Location</option>`;
                        // console.log(response)
                        response.forEach(element => {
                            data_str += `<option value="${element.id}">${element.name}</option>`;
                        });
                        $('#'+location_html).html(data_str);
                    },
                    error: function (error) {
                        console.log(error.responseJSON.message)
                    }
                });
            }


            function gt_autoApproved(){
                const staus_data_link = document.getElementById("staus_data_link").value;
                @php
                    $status = $gatepasss_status_each ? $gatepasss_status_each->status  : null;
                @endphp
                if(staus_data_link == "A" && "{{ $status }}" == "P"){
                    Swal.fire({
                        title: "Do you want to approved gatepass?",
                        text: "Once approved, you will not be able to make changes and send the gatepass to the next approvers",
                        icon: "warning",
                        allowOutsideClick: false,
                        // allowEscapeKey: false,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Aprroved",
                        denyButtonText: `Cancel`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Processing...",
                                text: "Please wait while the gatepass is being approved.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    var gatepass_id = document.getElementById("gatepass_id_data").value;
                                    @php
                                        $id_data = $gatepasss_status_each ? $gatepasss_status_each->id  : null;
                                    @endphp
                                    var user_id = "{{ Auth::user()->id }}";
                                    var status = "A";
                                    var appr_id = "{{ $id_data  }}"
                                    console.log("data",appr_id)
                                    $.ajax({
                                        type: "POST",
                                        url: "/Gatepass/approvers",
                                        data: {
                                            "_token": '{{ csrf_token() }}',
                                            "appr_id": appr_id,
                                            "user_id": user_id,
                                            "status": status,
                                            "gatepass_id": gatepass_id
                                        },
                                        success: function (response) {
                                            // Swal.close();
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
                } else if(staus_data_link == "R" && "{{ $status }}" == "P"){
                    Swal.fire({
                        title: "Do you want to Reject gatepass?",
                        text: "Once reject, you will not be able to make changes.",
                        icon: "error",
                        allowOutsideClick: false,
                        // allowEscapeKey: false,
                        showDenyButton: true,
                        showCancelButton: false,
                        confirmButtonText: "Reject",
                        denyButtonText: `Cancel`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Processing...",
                                text: "Please wait while the gatepass is being reject.",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    var gatepass_id = document.getElementById("gatepass_id_data").value;
                                    @php
                                        $id_data = $gatepasss_status_each ? $gatepasss_status_each->id  : null;
                                    @endphp
                                    var user_id = "{{ Auth::user()->id }}";
                                    var status = "R";
                                    var appr_id = "{{ $id_data }}"
                                    console.log("data",appr_id)
                                    $.ajax({
                                        type: "POST",
                                        url: "/Gatepass/approvers",
                                        data: {
                                            "_token": '{{ csrf_token() }}',
                                            "appr_id": appr_id,
                                            "user_id": user_id,
                                            "status": status,
                                            "gatepass_id": gatepass_id
                                        },
                                        success: function (response) {
                                            // Swal.close();
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
                }
            }

            $(document).ready(function() {
                if("{{$data_gatepass->is_finalized}}"){
                    gt_autoApproved(); 
                }
                // gt_autoApproved();
                $('#from_company').on('change', function() {
                    getDepartment('from_company', 'from_department');
                })

                $('#from_department').on('change', function() {
                    getLocation('from_company', 'from_department', 'from_location');
                })


                $('#to_company').on('change', function() {
                    getDepartment('to_company', 'to_department');
                })

                $('#to_department').on('change', function() {
                    getLocation('to_company', 'to_department', 'to_location');
                })

                $('#to_finalize').click(function (e) {
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
                            Swal.fire({
                                title: "Processing...",
                                html: `
                                    <div style="display: flex; align-items: center; flex-direction: column;">
                                        <div class="loader"></div>
                                        <p>Please hold on while the request is being processed.</p>
                                    </div>
                                    <style>
                                        .loader {
                                            border: 4px solid #f3f3f3;
                                            border-top: 4px solid #3498db;
                                            border-radius: 50%;
                                            width: 40px;
                                            height: 40px;
                                            animation: spin 1s linear infinite;
                                        }
                                        @keyframes spin {
                                            0% { transform: rotate(0deg); }
                                            100% { transform: rotate(360deg); }
                                        }
                                    </style>
                                `,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    var gatepass_id = document.getElementById("gatepass_id_data").value;
                                    $.ajax({
                                        type: "POST",
                                        url: "/Gatepass/finalize",
                                        data: {
                                        "_token": '{{ csrf_token() }}',
                                        "gatepass_id": gatepass_id
                                    },
                                    success: function (response) {
                                        toastr.success(response.message);
                                        location.reload();
                                    },
                                    error: function (error) {
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


                
                
            });

            $(document).on("click", "#btn_approved_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let gatepass_id = $(this).attr("data-gatepass_id");
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
                            var id = document.getElementById("gatepass_id_data").value;
                            $.ajax({
                                type: "POST",
                                url: "/Gatepass/approvers",
                                data: {
                                    "_token": '{{ csrf_token() }}',
                                    "appr_id": appr_id,
                                    "user_id": user_id,
                                    "status": status,
                                    "gatepass_id": gatepass_id
                                },
                                success: function (response) {
                                    // Swal.close();
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

            $(document).on("click", "#btn_reject_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let gatepass_id = $(this).attr("data-gatepass_id");
                

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
                    var id = document.getElementById("gatepass_id_data").value;
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
                    //         swal.close();
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
        </script>
</x-app-layout>