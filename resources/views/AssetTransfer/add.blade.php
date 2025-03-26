<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Transfer') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Add Asset Transfer</h4>
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
                                                    <select name="issuance_id" id="issuance_id" class="form-select" style="height: 100%;">
                                                        <option value="" disabled selected >please select</option>
                                                        @foreach ($data_issuance as $issuance)
                                                            <option value="{{ $issuance->id }}">{{ $issuance->rev_num }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{-- <a type="button" class="btn btn-info">find</a> --}}
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="bttn_find"></label>
                                                    <br>
                                                    {{-- <input type="text" class="form-control" name="issuance_id" id="issuance_id"> --}}
                                                    <a type="button" class="btn btn-info" id="bttn_find">Find</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                <form action="./add" method="post" enctype="multipart/form-data">  
                                    @csrf
                                    <input type="hidden" name="issuance_id_show" id="issuance_id_show" value="">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <h4>From</h4>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Asset Issuance No</label>
                                                    <input type="text" class="form-control" name="from_issuance_no" id="from_issuance_no" readonly> 
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Assign Employee</label>
                                                    <input type="text" class="form-control" name="from_employee" id="from_employee" readonly> 
                                                    <input type="hidden"  name="from_employee_id" id="from_employee_id"> 
                                                </div>
                                            </div>

        
                                            
                                            
                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Asset Details</label>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Asset Tag</th>
                                                                <th>Category</th>
                                                                <th>Model</th>
                                                                <th>Serial No.</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody  id="tbody_data">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <h4>To</h4>
                                        <hr>
                                        
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Transfer To Assign Employee</label>
                                                <select class="form-select" id="to_emp_id" name="to_emp_id" onchange="getEmployeeData()">
                                                    <option value="" disabled selected></option>
                                                    @foreach ($employee_data as $emp_data)
                                                        <option value="{{ $emp_data->id }}">{{ $emp_data->emp_no . " : ". $emp_data->first_name . " " . $emp_data->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Report to</label>
                                                <input type="text" name="report_to" id="report_to" class="form-control" value="" required>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Location<span class="text-red">*</span></label>
                                                {{-- <input type="text" class="form-control" id="location_id" name="location_id"  value=""> --}}
                                                <select class="form-control" id="location_id" name="location_id" required>
                                                </select>
                                            </div>

                                            
                                            
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Deployment Type: </label>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="temporary" name="deployment_type" value="temporary">
                                                    <label class="form-check-label" for="temporary">For temporary</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="permanent" name="deployment_type" value="permanent">
                                                    <label class="form-check-label" for="permanent">For permanent</label>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-9">
                                                <label class="form-label">Duration</label>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">From</label>
                                                        <input type="date" class="form-control" name="duration_from">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">To</label>
                                                        <input type="date" class="form-control" name="duration_to">
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Date Requested</label>
                                                <input type="date" class="form-control" id="date_requested" name="date_requested" value="">
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Date needed</label>
                                                <input type="date" class="form-control" id="date_need" name="date_need"  value="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Ref RSS</label>
                                                <input type="text" name="rev_rss" id="rev_rss" class="form-control" value="" required>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <input type="hidden" name="selected_transfer" id="selected_transfer" value="">
                                    <button type="submit" class="btn btn-outline-primary mt-4 w-100">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script>

    function getCheckVal(){
        var data_val = document.getElementsByName("data_ischeck");
        let val = [];
        for (let index = 0; index <= data_ischeck.length-1; index++) {
            const element = data_ischeck[index];
            if(element.checked){
                val.push(element.value)
                
            }
        }
        const result = val.join('~');
        document.getElementById("selected_transfer").value = result
        // console.log(result)
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
                    if(response.length == 0){
                        Swal.fire({
                            title: "Missing Details.",
                            html: "Please check the details of employee possible there is no company and department tag on the profile. <br> <b>No Location Found! </b>",
                            icon: "warning"
                        });
                    }
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

    function getEmployeeData(){
        var tp_empid = document.getElementById("to_emp_id").value;

        $.ajax({
            type: "POST",
            url: "/AssetTransfer/emp_data",
            data: {
                "_token": "{{ csrf_token() }}",
                'to_empid' : tp_empid
            },
            success: function (response) {
                console.log(response)

                var company = response.data.company_data_id;
                var department = response.data.department_data_id;
                getLocation(company, department);
            }
        });
    }

    $('#bttn_find').click(function (e) { 
        var data_val = $('#issuance_id').val();

        $.ajax({
            type: "POST",
            url: "./search",
            data: {
                '_token': "{{ csrf_token() }}",
                'issuance_id': data_val
            },
            success: function (response) {
                document.getElementById("from_issuance_no").value = response.data.rev_num
                document.getElementById("from_employee").value = response.data.get_employee.first_name + " " + response.data.get_employee.last_name
                document.getElementById("from_employee_id").value = response.data.get_employee.id;
                
                let data_body = "";
                document.getElementById("issuance_id_show").value = response.data.id;
                response.data.asset_details.forEach(element => {
                    data_body += "<tr>";
                        data_body += "<td><input type='checkbox' id='data_ischeck' name='data_ischeck' value='"+element.asset_id+"' onclick='getCheckVal()'></td>";
                        data_body += "<td>"+element.asset_id+"</td>";
                        data_body += "<td>"+element.asset_description+"</td>";
                        data_body += "<td>"+element.model_no+"</td>";
                        data_body += "<td>"+element.serial_number+"</td>";
                    data_body += "</td>";
                    console.log(element)
                });
                
                document.getElementById("tbody_data").innerHTML = data_body;
                console.log(response)
            }
        });
        // alert(data_val)
        
    });

</script>
</x-app-layout>