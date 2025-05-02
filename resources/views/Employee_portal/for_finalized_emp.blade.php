<x-employee-auth-layout>
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
                                    <input type="hidden" name="borrowed_id" id="borrowed_id" value="{{ $data->id }}">
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
                                                <table class="table text-center" id="{{ $view_table }}">
                                                    <thead>
                                                        <tr>
                                                            <th>Category</th>
                                                            <th>Comment</th>
                                                            <th>Return Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $x = 0;
                                                        @endphp

                                                        @foreach ($data->details as $assetdetl)
                                                        <tr>
                                                            <td>{{ $assetdetl->category_details->name }}</td>
                                                            <td>{{ $assetdetl->comments }}</td>
                                                            <td>{{ $assetdetl->date }}</td>
                                                        
                                                            <td>
                                                                @if ($data->is_finalized)
                                                                    <button type="button" class="btn btn-outline-primary viewDetails" data-comments="{{ $assetdetl->comments  }}" data-date_return="{{ $assetdetl->date  }}" data-detl_id="{{ $assetdetl->id }}" onclick="showSwal({{ $assetdetl->id }}, false)">Details</button>
                                                                @else
                                                                    {{-- <button type="button" class="btn btn-outline-primary viewDetails" data-comments="{{ $assetdetl->comments  }}" data-date_return="{{ $assetdetl->date  }}" data-detl_id="{{ $assetdetl->id }}" onclick="showSwal({{ $assetdetl->id }})">Details</button> --}}
                                                                    <button type="button" class="btn btn-outline-danger viewDetails" onclick="getDelete({{ $assetdetl->id }})" >Delete</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                            
                                                        @endforeach
                                                        
                                                        <input type="hidden" id="last_count_data" value="{{ $x }}">
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        {{-- <input type="hidden" name="borrowed_id" id="borrowed_id" value="{{ $data->id }}"> --}}
                                        @if ($data->is_finalized)
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
                                        @else
                                            <button class="btn btn-primary mt-4 w-100" type="button" onclick="final_data()">Finalize</button>
                                        @endif
                                        
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
            function showSwal(id, data_stat = true) {
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
                            showConfirmButton: data_stat,
                            confirmButtonText: 'Submit',
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
                    url: "/employee/BorrowedAsset/getDeleteDetl",
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
                    // <input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false">
                    var newRow = `
                        <tr>
                            <td>
                                <select class="form-control" id="category_${newRowId}" name="category_${newRowId}">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" data-id="${newRowId}" id="data_comment_${newRowId}" name="data_comment" autocomplete="off" autocorrect="off" spellcheck="false">
                            </td>
                            <td>
                                <input type="date" class="form-control" id="data_date_${newRowId}" name="data_date" >
                            </td>
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

            function getSave_detl(i, comment, date, category){
                var main_id = document.getElementById("borrowed_id").value;
                $.ajax({
                    type: "POST",
                    url: "/employee/BorrowedAsset/add_detl",
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "category_id": category,
                        "comment": comment,
                        "date_to_return": date,
                        "borrowed_id": main_id
                    },
                    success: function (response) {
                        // console.log(response)
                        var button = $('#data_save_'+i);
                        var button_remove = $('#data_remove_'+i);
                        // button.replaceWith(`<button type="button" class="btn btn-outline-primary viewDetails" onclick="showSwal(`+response.data.id+`)">Details</button>`);
                        button.replaceWith(``);
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
                        url: "/employee/BorrowedAsset/finalized",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "borrowed_id": main_id
                        },
                        success: function (response) {
                            swal.close();
                            toastr.success(response.message);
                            // location.reload();
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

                // function addNewRow() {
                    
                //     var rowCount = parseInt($('#last_count_data').val()); // Get current row count
                //     var newRowId = rowCount + 1; // Unique ID for new row
                //     // <input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false">
                //     // <span class="text-center" id="asset_description${newRowId}"></span>
                //     // <span class="text-center" id="serial_${newRowId}"></span>
                //     var newRow = `
                //         <tr>
                //             <td>
                                
                //                 <select class="form-control" id="category_${newRowId}" name="category_${newRowId}">
                //                     <option value="" disabled selected>Select Category</option>
                //                     @foreach ($category as $cat)
                //                         <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                //                     @endforeach
                //                 </select>
                //             </td>
                //             <td>
                //                 <input type="text" class="form-control" data-id="${newRowId}" id="data_comment_${newRowId}" name="data_comment" autocomplete="off" autocorrect="off" spellcheck="false">
                //             </td>
                //             <td>
                //                 <input type="date" class="form-control" id="data_date_${newRowId}" name="data_date" >
                //             </td>
                //             <td>
                //                 <button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                //                 <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>
                //             </td>
                //         </tr>
                //     `;
                //     $('#data_selected tbody').append(newRow);
                //     $('#last_count_data').val(newRowId)
                //     $('#data_' + newRowId).focus();
                // }

                function addNewRow() {
                    
                    var rowCount = parseInt($('#last_count_data').val()); // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    // <input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false">
                    // <span class="text-center" id="asset_description${newRowId}"></span>
                    // <span class="text-center" id="serial_${newRowId}"></span>
                    var newRow = `
                        <tr>
                            <td>
                                
                                <select class="form-control" id="category_${newRowId}" name="category_${newRowId}">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" data-id="${newRowId}" id="data_comment_${newRowId}" name="data_comment" autocomplete="off" autocorrect="off" spellcheck="false">
                            </td>
                            <td>
                                <input type="date" class="form-control" id="data_date_${newRowId}" name="data_date" >
                            </td>
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

                    // Handle "Save" button click
                    $('#data_selected tbody').on('click', '.saveRow', function () {
                        var row = $(this).closest('tr'); // Get the row


                        const category = row.find('select')[0].value; // Get selected value from the dropdown
                        const comment = row.find('input')[0].value; // Get input value
                        const date = row.find('input')[1].value; // Get input value

                        var button = $(this); // Reference to the button
                        if (category.trim() === "" || date.trim() === "") {
                            Swal.fire({
                                title: "Please select a category and input return date before saving.",
                                icon: "error"
                            });
                            return;
                        }
                        // borrowed_id
                        var rowCount2 = parseInt($('#last_count_data').val());
                        var intCurrent = rowCount2;
                        // var text_data = $('#category_'+intCurrent);
                        var text_data = $('#category_' + intCurrent + ' option:selected').text();
                        var text_comment = $('#data_comment_'+intCurrent);
                        var text_date = $('#data_date_'+intCurrent);



                        var text_data2 = $('#category_'+intCurrent);
                        var text_data3 = $('#data_comment_'+intCurrent);
                        var text_data4 = $('#data_date_'+intCurrent);
                        text_data2.replaceWith(`<span class="text-center" id="category_${intCurrent}">`+text_data+`</span>`);
                        text_data3.replaceWith(`<span class="text-center" id="data_comment_${intCurrent}">`+text_comment.val()+`</span>`);
                        text_data4.replaceWith(`<span class="text-center" id="data_date_${intCurrent}">`+text_date.val()+`</span>`);

                        getSave_detl(intCurrent, comment, date, category);
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
    
</x-employee-auth-layout>