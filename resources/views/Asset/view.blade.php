<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Asset
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
                                        <th class="staff_thead_name">Asset Code</th>
                                        <th class="staff_thead_email">Asset Description </th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asset as $ass)
                                        <tr>
                                            <td><img class="rounded-circle" width="75" height="60" src="{{ $ass->image_path == "" ? asset('images/dummy-prod-1.jpg' ): asset('storage/'.$ass->image_path )  }}" alt="image"></td>
                                            <td>{{ $ass->asset_id }}</td>
                                            <td>{{ $ass->asset_description }}</td>
                                            <td>{{ $ass->asset_status_data->status ?? 'N/A' }}</td>
                                            <td><a class="badge badge-lg badge-info" id="staff_id_new" href="./edit/{{ $ass->id }}"><i class="la la-pencil"></i>Edit</a></td>
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
                                    <img id="imagePreview" src="https://placehold.co/200" alt="Profile Image" class="img-fluid rounded-circle mb-2" width="200">
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
        

</x-app-layout>