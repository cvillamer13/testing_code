<x-app-layout>
    <x-slot name="header">
            {{ __('Borrowed Asset') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Add Borrowed Asset</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                {{-- <form class="needs-validation" action="/BorrowedAsset/for_finalize/{{ $data->id }}" method="post" enctype="multipart/form-data"> --}}
                                    @csrf
                                    <h5 class="card-title">{{ $data->ref_num }}</h5>
                                    @if ($data->status == "A")
                                        <div class="row">
                                            <div class="card-title col-6">
                                                <a type="button" class="btn btn-outline-success" href="/BorrowedAsset/pdf_report/{{ $data->id }}"  target="_blank"><i class="las la-print"></i>Print Transmittal Form</a>
                                                <a type="button" class="btn btn-outline-primary" href="/BorrowedAsset/gate_passchecker/{{ $data->id }}" target="_blank"><i class="las la-print"></i>Print Gatepass</a>
                                            </div>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Employee number</label>
                                                    <input type="text" class="form-control" id="name_data" value="{{ $data->getEmployee->emp_no }}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name_data" value="{{ $data->getEmployee->first_name . ' ' . $data->getEmployee->last_name  }}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Designation</label>
                                                    <input type="text" class="form-control" id="position_data"  value="{{ $data->getEmployee->position->position_name  }}" readonly disabled>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Business unit</label>
                                                    <input type="text" class="form-control" id="company_data"  value="{{ $data->getEmployee->company->name  }}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Department</label>
                                                    <input type="text" class="form-control" id="department_data"  value="{{ $data->getEmployee->department->name  }}" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email_data"  value="{{ $data->getEmployee->email  }}" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone_data"  value="{{ $data->getEmployee->phone_number }}" readonly disabled>
                                                </div>
                                                
                                            </div>
                                            <hr>
                                            <h5 class="card-title">Location</h5>
                                            <table class="table text-center" border="1">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">FROM</th>
                                                        <th colspan="3">TO<span class="text-red">*</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th>COMPANY</th>
                                                        <th>DEPARTMENT</th>
                                                        <th>LOCATION</th>
                                                        <th>COMPANY</th>
                                                        <th>DEPARTMENT</th>
                                                        <th>LOCATION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $data->getLocation_from->company->name }}</td>
                                                        <td>{{ $data->getLocation_from->department->name }}</td>
                                                        <td>{{ $data->getLocation_from->location_data->name }}</td>
                                                        <td>{{ $data->getLocation_to->company->name }}</td>
                                                        <td>{{ $data->getLocation_to->department->name }}</td>
                                                        <td>{{ $data->getLocation_to->location_data->name }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Date Requested</label>
                                                    <input type="date" class="form-control" id="date_requested" name="date_requested" value="{{ $data->requested_at }}" readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Deployed Date</label>
                                                    <input type="date" class="form-control" id="date_need" name="date_need"  value="{{ $data->deployed_at }}" readonly>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Ref. RSS Ticket Numbers</label>
                                                    <input type="text" class="form-control" id="rss_num" name="rss_num"  value="{{ $data->ref_rss }}" readonly>
                                                </div>
                                            </div>


                                            <hr>
                                            <h5 class="card-title">Equipment List</h5>
                                                @php
                                                    if($data->is_finalized){
                                                        $view_table="data_notselected";
                                                    }else{
                                                        $view_table="data_selected";
                                                    }
                                                @endphp
                                                <table class="table text-center" id="data_notselected">
                                                    <thead>
                                                        <tr>
                                                            <th>Asset Tag</th>
                                                            <th>Asset Description</th>
                                                            <th>Serial No</th>
                                                            {{-- <th>Comment</th>
                                                            <th>Date to return</th> --}}
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $x = 0;
                                                        @endphp

                                                        @foreach ($data->details as $assetdetl)
                                                        <tr>
                                                            <td>{{ $assetdetl->asset_details->asset_id }}</td>
                                                            <td>{{ $assetdetl->asset_details->asset_description }}</td>
                                                            <td>{{ $assetdetl->asset_details->serial_number }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-outline-primary viewDetails" data-comments="{{ $assetdetl->comments  }}" data-date_return="{{ $assetdetl->date  }}" data-detl_id="{{ $assetdetl->id }}" onclick="showSwal({{ $assetdetl->id }})">Details</button>
                                                                <button type="button" class="btn btn-outline-danger viewDetails" onclick="getDelete({{ $assetdetl->id }})" >Delete</button>
                                                            </td>
                                                        </tr>
                                                            
                                                        @endforeach
                                                        
                                                        <input type="hidden" id="last_count_data" value="{{ $x }}">
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" name="borrowed_id" id="borrowed_id" value="{{ $data->id }}">
                                        
                                        <div class="row">
                                            <h5 class="card-title">Approvers</h5>
                                            <hr>
                                            @foreach ($borrowed_status as $data)
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
                                                        <button type="button" class="btn btn-outline-success flex-fill" id="btn_approved_data" 
                                                        data-id="{{ $data->id }}" 
                                                        data-user_id="{{ $data->user->id }}" 
                                                        data-status="A" 
                                                        data-asset_iss_id="{{ $borrowed->id }}
                                                        ">Approved</button>
                                                        <button type="button" class="btn btn-outline-danger flex-fill" id="btn_reject_data" data-id="{{ $data->id }}" data-user_id="{{ $data->user->id }}" data-status="R" data-asset_iss_id="{{ $borrowed->id }}">Reject</button>
                                                        
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
                                       
                                        <input type="hidden" name="status_data" id="status_data" value="{{ $status }}">
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
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
                        document.getElementById("position_data").value = response.position.position_name;
                        document.getElementById("company_data").value = response.company.name;
                        document.getElementById("department_data").value = response.department.name;
                        document.getElementById("email_data").value = response.email;
                        document.getElementById("phone_data").value = response.phone_number;
                    }
                });
            }

            function getDepartment(){
                var company_id = $('#to_company').val();
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
                    
                        $('#to_department').html(data_str);
                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
            function getLocation(){
                var company = $('#to_company').val();
                var department =  $('#to_department').val();
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
                            $('#to_location').html(data_str);
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                        }
                    });
            }
            function showSwal(id) {
                Swal.showLoading();
                $.ajax({
                    type: "POST",
                    url: "/BorrowedAsset/getData_detl",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "detl_id": id
                    },
                    success: function (response) {
                        if(response.status == "success"){
                            Swal.fire({
                            title: 'Enter Details',
                            html: `
                                <label class="form-label">Date to return</label>
                                <input type="date" class="form-control" id="swal-input-date" value="${response.data.date ?? "" }" >

                                <label class="form-label">Comments</label>
                                <textarea class="form-control" id="swal-input-text">${response.data.comments ?? "" }</textarea>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            // confirmButtonText: 'Submit',
                            preConfirm: () => {
                                const text = document.getElementById('swal-input-text').value;
                                const date = document.getElementById('swal-input-date').value;
                                
                                if (!text || !date) {
                                    Swal.showValidationMessage('Both fields are required!');
                                }

                                return { text, date };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: "/BorrowedAsset/saveOtherDetl",
                                    data: {
                                        "_token": '{{ csrf_token() }}',
                                        "comment": result.value.text,
                                        "date_of_return":result.value.date,
                                        "detl_id": id
                                    },
                                    success: function (response) {
                                        if(response.status == "success"){
                                            toastr.success("Other Details Saved");
                                            Swal.close();
                                            location.reload();
                                        }
                                    },
                                    error: function (error) {
                                        // console.log(error)
                                        Swal.close();
                                        toastr.error("Error: " + error.responseJSON.message);
                                    }
                                });
                            }
                        });
                                }
                            },
                            error: function (error) {
                                // console.log(error)
                                Swal.close();
                                toastr.error("Error: " + error.responseJSON.message);
                            }
                        });
                
            }

            function getDelete(id){
                Swal.showLoading();
                $.ajax({
                    type: "DELETE",
                    url: "/BorrowedAsset/getDeleteDetl",
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
                        // console.log(error)
                        Swal.close();
                        toastr.error("Error: " + error.responseJSON.message);
                    }
                });
            }

            function addNewRow1(rowId) {
                    var rowId = parseInt($('#last_count_data').val());
                    var rowCount = parseInt(rowId) // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    // console.log('addNewRow1', newRowId);
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false"></td>
                            <td><span class="text-center" id="asset_description${newRowId}"></span></td>
                            <td><span class="text-center" id="serial_${newRowId}"></span></td>
                            <td>
                                <button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                                <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>
                            </td>
                        </tr>
                `;
                $('#data_selected tbody').append(newRow);
                $('#last_count_data').val(newRowId);
                $('#data_' + newRowId).focus();
            }

            function getSave_detl(i, asset_id, comment, date_return){
                var main_id = document.getElementById("borrowed_id").value;
                $.ajax({
                    type: "POST",
                    url: "/BorrowedAsset/add_detl/",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "asset_id": asset_id,
                        "comment": comment,
                        "date_to_return": date_return,
                        "borrowed_id": main_id
                    },
                    success: function (response) {
                        // console.log(response)
                        var button = $('#data_save_'+i);
                        var button_remove = $('#data_remove_'+i);
                        button.replaceWith(`<button type="button" class="btn btn-outline-primary viewDetails" onclick="showSwal(`+response.data.id+`)">Details</button>`);
                        button_remove.replaceWith(`<button type="button" class="btn btn-outline-danger viewDetails" onclick="getDelete(`+response.data.id+`)" >Delete</button>`);
                            // Add a new row to allow further inputs
                        addNewRow1(i);
                        // location.reload();

                        Swal.close();
                    }
                });
            }

            function final_data(){
                Swal.fire({
                    title: "Do you want to finalized the Borrowed Asset?",
                    text: "Once finalized, you will not be able to make changes and the request will send for approval",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Finalize",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var main_id = document.getElementById("borrowed_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/BorrowedAsset/finalized",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "borrowed_id": main_id
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


            $(document).ready(function () {
                // var table = $('#example3').DataTable();
                var datastatus = $('#status_data').val();
                
                if (datastatus == "A") {
                    // alert(datastatus)
                    $("#btn_approved_data").trigger("click");
                }else if(datastatus == "R"){
                    
                    $("#btn_reject_data").trigger("click");
                }
                // $("#btn_approved_data").trigger("click");
                function addNewRow() {
                    
                    var rowCount = parseInt($('#last_count_data').val()); // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false"></td>
                            <td><span class="text-center" id="asset_description${newRowId}"></span></td>
                            <td><span class="text-center" id="serial_${newRowId}"></span></td>
                            <td>
                                <button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                                <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#data_selected tbody').append(newRow);
                    $('#last_count_data').val(newRowId)
                    $('#data_' + newRowId).focus();
                }

                    $('#data_selected tbody').on('keypress', 'input', function (event) {
                        if (event.which === 13) {  // 13 = Enter key
                            event.preventDefault();  // Prevent form submission

                            var barcodeValue = $(this).val();  // Get the barcode value
                            var rowId = $(this).attr('data-id');  // Get the row's data-id

                            console.log("Scanned Barcode:", barcodeValue, "Row ID:", rowId);

                            Swal.showLoading();
                            $.ajax({
                                url: '/AssetAssign/getAsset', // Replace with your actual API endpoint
                                method: 'POST',
                                data: { 
                                    "_token": '{{ csrf_token() }}',
                                    "asset_id": barcodeValue
                                },
                                success: function (response) {
                                    if(response.status == "success"){
                                        var rowCount2 = parseInt($('#last_count_data').val());
                                        var intCurrent = rowCount2;
                                        // console.log("start",rowCount2)
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
                                            document.getElementById("asset_description"+intCurrent).innerHTML = response.data.asset_description
                                            document.getElementById("serial_"+intCurrent).innerHTML = response.data.serial_number
                                            getSave_detl(intCurrent, response.data.id);
                                            // addNewRow()
                                            
                                        }
                                },
                                error: function (error) {
                                }
                            });
                            $(this).closest('tr').next().find('input').focus();
                            // You can now process the barcode value (e.g., send via AJAX, update table, etc.)
                        }
                    });

                    // Handle "Save" button click
                    $('#data_selected tbody').on('click', '.saveRow', function () {
                        var row = $(this).closest('tr'); // Get the row
                        var inputData = row.find('input').val(); // Get input value
                        var button = $(this); // Reference to the button
                        // console.log(inputData)
                        if (inputData.trim() === "") {
                            alert("Please enter a value before saving.");
                            return;
                        }
                        // var main_id = document.getElementById("issuance_id").value;
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
                                    // console.log("start",rowCount2)
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
                                        document.getElementById("asset_description"+intCurrent).innerHTML = response.data.asset_description
                                        document.getElementById("serial_"+intCurrent).innerHTML = response.data.serial_number
                                        getSave_detl(intCurrent, response.data.id);
                                        // addNewRow()
                                        
                                    }
                            },
                            error: function (error) {
                            }
                        });
                    });

                    // Handle "Remove" button click
                    $('#data_selected tbody').on('click', '.removeRow', function () {
                        var table = $('#data_selected').DataTable();
                        table.row($(this).closest('tr')).remove().draw(false);
                    });

                    // Initial row
                    addNewRow();
                    
            });

            
            $(document).on("click", "#btn_approved_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let asset_iss_id = $(this).attr("data-asset_iss_id");
                // Swal.showLoading();

                Swal.fire({
                    title: "Do you want to approved borrowed request?",
                    html: "Once approved, you will not be able to make changes and send the request to the next approvers",
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
                            $.ajax({
                                type: "POST",
                                url: "/BorrowedAsset/approvers",
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

            $(document).on("click", "#btn_reject_data", function () {
                let appr_id = $(this).attr("data-id");
                let user_id = $(this).attr("data-user_id");
                let status = $(this).attr("data-status");
                let asset_iss_id = $(this).attr("data-asset_iss_id");
                

                Swal.fire({
                    title: "Do you want to borrowed request?",
                    html: "Once Disaprroved, you will not be able to make changes. <br> <textarea class='form-control' name='reason_data' id='reason_data' placeholder='Reason'></textarea>",
                    icon: "error",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Disaprroved",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    // var id = document.getElementById("issuance_id").value;
                    var reason_data = document.getElementById("reason_data").value;
                    $.ajax({
                        type: "POST",
                        url: "/BorrowedAsset/approvers",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "appr_id": appr_id,
                            "user_id": user_id,
                            "status": status,
                            "asset_iss_id": asset_iss_id,
                            "reason_data": reason_data
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

        </script>
    
</x-app-layout>