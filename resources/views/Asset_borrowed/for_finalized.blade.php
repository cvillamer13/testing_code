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
                                                        <td>{{ $data->getLocation_from->name }}</td>
                                                        <td>{{ $data->getLocation_to->company->name }}</td>
                                                        <td>{{ $data->getLocation_to->department->name }}</td>
                                                        <td>{{ $data->getLocation_to->name }}</td>
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
                                                <table class="table text-center" id="data_selected">
                                                    <thead>
                                                        <tr>
                                                            <th>Asset Tag</th>
                                                            <th>Asset Description</th>
                                                            <th>Serial No</th>
                                                            <th>Comment</th>
                                                            <th>Date to return</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $x = 0;
                                                        @endphp
                                                        
                                                        <input type="hidden" id="last_count_data" value="{{ $x }}">
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" name="borrowed_id" id="borrowed_id" value="{{ $data->id }}">
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Finalize</button>
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

            function getSave_detl(i, asset_id, comment, date_return){
                var main_id = document.getElementById("borrowed_id").value;
                $.ajax({
                    type: "POST",
                    url: "/BorrowedAsset/add_detl/"+main_id,
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "asset_id": asset_id,
                        "comment": comment,
                        "date_to_return": date_return,
                        "borrowed_id": main_id
                    },
                    success: function (response) {
                        console.log(response)
                        var button = $('#data_save_'+i);
                        var button_remove = $('#data_remove_'+i);
                        button.replaceWith(``);
                        button_remove.replaceWith(`<button type="button" class="btn btn-outline-danger viewDetails" onclick="getDelete(`+response.data.id+`)" >Delete</button>`);
                            // Add a new row to allow further inputs
                        addNewRow1(i);
                        // location.reload();

                        Swal.close();
                    }
                });
            }


            $(document).ready(function () {
                // var table = $('#example3').DataTable();

                function addNewRow() {
                    
                    var rowCount = parseInt($('#last_count_data').val()); // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    var newRow = `
                        <tr>
                            <td><input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false"></td>
                            <td><span class="text-center" id="asset_description${newRowId}"></span></td>
                            <td><span class="text-center" id="serial_${newRowId}"></span></td>
                            <td><input type="text" class="form-control" id="comment_${newRowId}"></td>
                            <td><input type="date" class="form-control" id="date_return_${newRowId}"></td>
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
                                        // document.getElementById("category_"+intCurrent).innerHTML = response.data.category_data.name
                                        document.getElementById("asset_description"+intCurrent).innerHTML = response.data.asset_description
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
                    $('#data_selected tbody').on('click', '.removeRow', function () {
                        var table = $('#data_selected').DataTable();
                        table.row($(this).closest('tr')).remove().draw(false);
                    });

                    // Initial row
                    addNewRow();
                    
            });

        </script>
    
</x-app-layout>