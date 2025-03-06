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
                                <center><span class="text-red">*</span> - <b>Required</b></center>
                                <br>
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
                                                    <p class="form-control-plaintext" id="position_data">{{ $employee_data->position->position_name }}</p>
                                                </div>
                                            </div>
                                            

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Business unit</label>
                                                    <p class="form-control-plaintext" id="company_data"><b>{{ $employee_data->company->name }}</b></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Department</label>
                                                    <p class="form-control-plaintext" id="department_data"><b>{{ $employee_data->department->name }}</b></p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Reports To<span class="text-red">*</span></label>
                                                    <p class="form-control-plaintext" id="reports_to"><b>{{ $asset_issuance->reports_to }}</b></p>
                                                </div>
                                                <div class=" col-md-3">
                                                    <label class="form-label">Location<span class="text-red">*</span></label>
                                                    <select class="form-control" id="location_id" name="location_id">
                                                    </select>
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
                                                            <p class="form-control-plaintext"><b>{{ $asset_issuance->deployment_duration_from }}</b></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">To</label>
                                                            <p class="form-control-plaintext"><b>{{ $asset_issuance->deployment_duration_to }}</b></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Date Requested</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->date_requested }}</b></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Date Needed</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->date_needed }}</b></p>
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="form-label">Ref. RSS Ticket Numbers</label>
                                                    <p class="form-control-plaintext"><b>{{ $asset_issuance->ref_rss  }}</b></p>
                                                </div>

                                                <input type="hidden" name="issuance_id" id="issuance_id" value="{{ $asset_issuance->id }}">
                                            </div>

                                            <div class="row" id="HIN_id">
                                                <hr>
                                                <h5 class="card-title">Hardware Information</h5>
                                                <div class="table-responsive">
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

                                                            @foreach ($issuance_detl as $detl)
                                                                <tr>
                                                                    <td>{{ $detl->asset_details->asset_id }}</td>
                                                                    <td><span class="text-center">{{ $detl->asset_details->category_data->name }}</span></td>
                                                                    <td><span class="text-center">{{ $detl->asset_details->model_no }}</span></td>
                                                                    <td><span class="text-center">{{ $detl->asset_details->serial_number }}</span></td>
                                                                    <td>
                                                                        {{-- <button type="button" id="save_0" class="btn btn-outline-primary"  data-toggle="modal" data-target="#EmployeeInfo" data-details_id="{{ $detl->id }}" asset_id_data="{{ $detl->asset_details->id }}">Details</button> --}}
                                                                        <button type="button" id="save_0" class="btn btn-outline-primary"  onclick="getdataall({{ $detl->id }}, {{ $detl->asset_details->id }})">Details</button>
                                                                        <button type="button" class="btn btn-outline-danger">Delete</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        
                                    
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Finalize</button>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EmployeeInfo" tabindex="-1" role="dialog" aria-labelledby="EmployeeInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="EmployeeInfoLabel">
                            Other Information
                        </h5>
                    </div>
                    
                    <div class="modal-body">
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
                                        <label class="form-check-label" for="temporary">VOIP ext</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_intpbx" name="is_intpbx">
                                        <label class="form-check-label" for="temporary">PBX ext</label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="temporary">WIFI SSID</label>
                                        <input type="text" class="form-control" id="company_data"  value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Drive(s)</label>
                                        <input type="text" class="form-control" id="company_data"  value="">
                                    </div>

                                    <div class="form-check">
                                        
                                        <label class="form-check-label" for="temporary">Shared Printer(s)</label>
                                        <input type="text" class="form-control" id="company_data"  value="">
                                    </div>
                                </div>
                            </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="close_modal()">Close</button>
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
                        var button = $('#data_save_'+i);
                        var button_remove = $('#data_remove_'+i);
                        button.replaceWith(`<button type="button" class="btn btn-outline-primary viewDetails" data-details_id="`+ response.data.id+`" >Details</button>`);
                        button_remove.replaceWith(`<button type="button" class="btn btn-outline-danger viewDetails">Delete</button>`);
                            // Add a new row to allow further inputs
                        addNewRow1(i);

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



            function addNewRow1(rowId) {
                var table = $('#example3').DataTable();
                    var rowCount = parseInt(rowId) // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    console.log("second", newRowId)
                    // table.row.add([
                    //         `<input type="text" class="form-control" data-id="${newRowId}" id="data_${newRowId}" autocomplete="off" autocorrect="off" spellcheck="false" >`,  // Unique data-id
                    //         `<span class="text-center" id="category_${newRowId}"></span>`,
                    //         `<span class="text-center" id="model_${newRowId}"></span>`,
                    //         `<span class="text-center" id="serial_${newRowId}"></span>`,
                    //         `<button type="button" id="data_save_${newRowId}" class="btn btn-outline-success saveRow">Save</button>
                    //         <button type="button" id="data_remove_${newRowId}" class="btn btn-outline-danger removeRow">Remove</button>`,
                    //     ]).draw(false);

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

                    // Append row to the LAST position of the table body
                        $('#example3 tbody').append(newRow);
                        $('#data_' + newRowId).focus();


                    }

            $(document).ready(function () {
                var table = $('#example3').DataTable();

                function addNewRow() {
                    var rowCount = table.rows().count(); // Get current row count
                    var newRowId = rowCount + 1; // Unique ID for new row
                    console.log("first", newRowId)
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

                // Append row to the LAST position of the table body
                    $('#example3 tbody').append(newRow);
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
                        console.log(inputData)
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
                                // console.log("Data saved:", response);

                                // // Change "Save" to "View Details"
                                // button.replaceWith(`<button type="button" class="btn btn-outline-primary">Details</button>`);

                                // // Add a new row to allow further inputs
                                // addNewRow();

                                if(response.status == "success"){
                                    var rowCount2 = table.rows().count();
                                    var intCurrent = rowCount2 + 1;
                                    // console.log("inp",intCurrent)
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
                                        
                                    }
                            },
                            error: function (error) {
                            }
                        });
                    });

                    // Handle "Remove" button click
                    $('#example3 tbody').on('click', '.removeRow', function () {
                        table.row($(this).closest('tr')).remove().draw(false);
                    });

                    // Initial row
                    addNewRow();
                    
            });

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
                        
                        
// Os_patch



                        $("#EmployeeInfo").modal("show");
                    })
                    
                    
                } catch (error) {
                    
                }
            }

            function close_modal(){
                $("#EmployeeInfo").modal("hide");
            }
        </script>
    
</x-app-layout>