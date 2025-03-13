<x-app-layout>
    <x-slot name="header">
            {{ __('Employee Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Employees</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Employee
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_no">Image</th>
                                        <th class="staff_thead_no">Employee Number</th>
                                        <th class="staff_thead_name">Full Name</th>
                                        <th class="staff_thead_email">Email </th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                        <th class="staff_thead_status">Asset Assigned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            {{-- <td><img class="rounded-circle" width="75" height="60" src="{{ asset('storage/'.$employee->image_path) }}" alt="image"></td> --}}
                                            <td><img class="rounded-circle" width="75" height="60" src="{{ $employee->image_path == "" ? asset('images/images.jpg' ): asset('storage/'.$employee->image_path )  }}" alt="image"></td>
                                            <td><a class="link-info" data-toggle="modal" data-target="#EmployeeInfo" onclick="EmpNodata({{ $employee->id }})">{{ $employee->emp_no }} </a></td>
                                            <td>{{ $employee->first_name . " " . $employee->last_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>
                                                <span class="badge badge-lg badge-outline-success">Active</span>
                                                {{-- <span class="badge badge-lg badge-outline-danger">Resigned</span> --}}
                                            </td>
                                            <td><a class="badge badge-lg badge-info" id="staff_id_new" href="./edit/{{ $employee->id }}"><i class="la la-pencil"></i>Edit</a></td>
                                            <td><a class="badge badge-lg badge-success" data-toggle="modal" data-target="#AssetAssigned" id="modal_assign" data-emp_id="{{ $employee->id }}"><i class="las la-eye"></i>view</a></td>
                                        </tr>
                                    @endforeach
                            </table>
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
                            Employee Information
                        </h5>
                    </div>
                    
                    <div class="modal-body">
                            <div class="row">
                                <!-- Profile Image Upload -->
                                <div class="mb-3 col-md-12 text-center">
                                    <label for="profile_image" class="form-label d-block">Profile Image</label>
                                    <img id="imagePreview" src="" alt="Profile Image" class="img-fluid rounded-circle mb-2" width="200">
                                </div>
        
                            </div>
                            <div class="row">
                                <h5>Basic Information</h5>
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Employee Number: </label><br>
                                        <span class="fw-bold" id="emp_no" ></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">First Name: </label>
                                        <br>
                                        <span class="fw-bold" id="f_name"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Middle Name: </label>
                                        <br>
                                        <span class="fw-bold" id="m_name"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Last Name: </label>
                                        <br>
                                        <span class="fw-bold" id="l_name"></span>
                                    </div>
                            </div>
        
                            <div class="row">
                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label" >Date of birth: </label>
                                    <br>
                                    <span class="fw-bold" id="dob"></span>
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label" >Gender: </label>
                                    <br>
                                    <span class="fw-bold" id="gender_data"></span>
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label input-group" >Email: </label>
                                    <br>
                                    <span class="fw-bold" id="email_data"></span>
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="employee_name" class="form-label">Phone Number: </label>
                                    <br>
                                    <span class="fw-bold" id="phone_number"></span>
                                </div>
                            </div>


                            <div class="row">
                                <h5>Designation Information</h5>
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Position: </label>
                                        <br>
                                        <span class="fw-bold" id="pistion_data"></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Date of hired: </label>
                                        <br>
                                        <span class="fw-bold" id="date_hired"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Company: </label>
                                        <br>
                                        <span class="fw-bold" id="company_data"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Department: </label>
                                        <br>
                                        <span class="fw-bold" id="department"></span>
                                    </div>
                            </div>


                            <div class="row">
                                <h5>Present Address</h5>
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Address 1: </label>
                                        <br>
                                        <span class="fw-bold" id="add1"></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Address 2: </label>
                                        <br>
                                        <span class="fw-bold" id="add2"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">Barangay: </label>
                                        <br>
                                        <span class="fw-bold" id="barang"></span>
                                    </div>

                                    <div class="mb-3 col-sm-3">
                                        <label for="employee_name" class="form-label">City: </label>
                                        <br>
                                        <span class="fw-bold" id="city"></span>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="mb-3 col-sm-4">
                                        <label for="employee_name" class="form-label">Province: </label>
                                        <br>
                                        <span class="fw-bold" id="province"></span>
                                    </div>
                                    
                                    <div class="mb-3 col-sm-4">
                                        <label for="employee_name" class="form-label">Zip Code: </label>
                                        <br>
                                        <span class="fw-bold" id="zip_code"></span>
                                    </div>

                                    <div class="mb-3 col-sm-4">
                                        <label for="employee_name" class="form-label">Country: </label>
                                        <br>
                                        <span class="fw-bold" id="country"></span>
                                    </div>
                            </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="modal fade" id="AssetAssigned" tabindex="-1" role="dialog" aria-labelledby="AssetAssignedLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="AssetAssignedLabel">
                            Asset Assigned Information
                        </h5>
                    </div>
                    
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <td>Asset Id</td>
                                        <td>Asset Name</td>
                                        <td>Status</td>
                                        <td>Last modified by</td>
                                        <td>Last modified at</td>
                                    </tr>
                                </thead>

                                <tbody id="tbody_data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script>

            function EmpNodata(id){
                try {
                    $.ajax({
                        type: "POST",
                        url: "./getEmployee",
                        data: { 
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            toastr.success("Employee Found!");

                            console.log(response)
                            document.getElementById("emp_no").innerHTML = response.emp_no;
                            document.getElementById("f_name").innerHTML = response.first_name;
                            document.getElementById("m_name").innerHTML = response.middle_name;
                            document.getElementById("l_name").innerHTML = response.last_name;
                            // https://placehold.co/200
                            // image_path
                            document.getElementById("imagePreview").src = "../storage/"+response.image_path
                            document.getElementById("dob").innerHTML = response.date_of_birth;
                            document.getElementById("gender_data").innerHTML = response.gender.gender_name;
                            document.getElementById("email_data").innerHTML = response.email;
                            document.getElementById("phone_number").innerHTML = response.phone_number;
                            
                            document.getElementById("pistion_data").innerHTML = response.position.position_name;
                            document.getElementById("date_hired").innerHTML = response.date_of_hired;
                            document.getElementById("company_data").innerHTML = response.company.name;
                            document.getElementById("department").innerHTML = response.department.name;

                            document.getElementById("add1").innerHTML = response.address1;
                            document.getElementById("add2").innerHTML = response.address2;
                            document.getElementById("barang").innerHTML = response.barangay;
                            document.getElementById("city").innerHTML = response.city;

                            document.getElementById("province").innerHTML = response.province;
                            document.getElementById("zip_code").innerHTML = response.zip;
                            document.getElementById("country").innerHTML = response.country;
                            
                        },
                        error: function (error) {
                            toastr.error("Employee not found");
                        }
                    });
                } catch (error) {
                    
                }
            }

            $(document).on("click", "#modal_assign", function () {
                const emp_id = $(this).attr('data-emp_id');
                //tbody_data
                console.log(emp_id)

                $.ajax({
                    type: "POST",
                    url: "/AssetAssign/getAssign",
                    data: {
                        id_emp: emp_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        let data_tbody = '';
                        response.data.forEach(element => {
                            if (element.get_asset_data != null) {
                                data_tbody += "<tr>";
                                    data_tbody += "<td>"+element.get_asset_data.asset_id+"</td>";
                                    data_tbody += "<td>"+element.get_asset_data.name+"</td>";
                                    if (element.status == "TRUE") {
                                        data_tbody += '<td><span class="badge badge-lg badge-outline-success">Assigned</span></td>';
                                    } else {
                                        data_tbody += '<td><span class="badge badge-lg badge-outline-danger">UnAssigned</span></td>';
                                    }
                                    
                                    data_tbody += "<td>"+element.updatedby+"</td>";

                                    const date = new Date(element.updated_at);
                                    const options = { 
                                        weekday: 'long', // Monday
                                        year: 'numeric',  // 2011
                                        month: 'long',    // March
                                        day: 'numeric',   // 7
                                        hour: 'numeric',  // 4
                                        minute: '2-digit',// 00
                                        second: '2-digit',// 00
                                        hour12: true,     // AM/PM format
                                        timeZone: 'Asia/Manila' // Convert to Manila Time
                                    };
                                    const formattedDate = date.toLocaleString('en-US', options);

                                    data_tbody += "<td>"+formattedDate+"</td>";
                                data_tbody += "</tr>";
                            }
                            // console.log(element)
                        });

                        document.getElementById("tbody_data").innerHTML = data_tbody;
                        
                    }
                });
            })



            
        </script>
</x-app-layout>