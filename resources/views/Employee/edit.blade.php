<x-app-layout>
    <x-slot name="header">
            {{ __('Employee Maintenance') }}
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <!-- Header with profile summary -->
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- <h4 class="card-title mb-0">Edit Employee</h4> --}}
                            <div class="employee-summary">
                                <div class="d-flex align-items-center">
                                    @if($employee->image_path)
                                        <img class="rounded-circle me-3" width="60" height="60"
                                            src="{{ asset('storage/'.$employee->image_path) }}" 
                                            alt="Employee Image">
                                    @endif
                                    <div>
                                        <h5 class="mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                                        <small class="text-white-50">Employee #{{ $employee->emp_no }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="card-body">
                        <div class="form-validation">
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i> Fields marked with <span class="text-danger">*</span> are required.
                            </div>
    
                            <form class="needs-validation" action="/Employee_DB/edit/{{ $employee->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Basic Information Section -->
                                <div class="section-container mb-5">
                                    <h5 class="section-title"><i class="fas fa-user me-2"></i> Basic Information</h5>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Employee number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="emp_no" id="emp_no" value="{{ $employee->emp_no }}" required>
                                            </div>
    
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Upload Profile Picture</label>
                                                <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                                            </div>
                                            <div class="mb-3 col-md-3 text-center">
                                                <img class="rounded-circle border" width="120" height="120"
                                                    src="{{ $employee->image_path ? asset('storage/'.$employee->image_path) : asset('images/images.jpg') }}"
                                                    alt="Profile Image">
                                                <div class="mt-2">
                                                    <small class="text-muted">Max 2MB</small>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="f_name" id="f_name" value="{{ $employee->first_name }}" required>
                                            </div>
    
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Middle Name</label>
                                                <input type="text" class="form-control" name="m_name" id="m_name" value="{{ $employee->middle_name }}">
                                            </div>
    
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="l_name" id="l_name" value="{{ $employee->last_name }}" required>
                                            </div>
                                        </div>
    
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Date of birth</label>
                                                <input type="date" class="form-control" name="dob" id="dob" value="{{ $employee->date_of_birth }}">
                                            </div>
    
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                                <select class="form-select" id="gender_data" name="gender_data" required>
                                                    <option value selected disabled>Select Gender</option>
                                                    @foreach ($gender as $gen)
                                                        @if ($employee->gender_id == $gen->id)
                                                            <option value="{{ $gen->id }}" selected>{{ $gen->gender_name }}</option>
                                                        @else
                                                            <option value="{{ $gen->id }}">{{ $gen->gender_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
    
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email_data" id="email_data" value="{{ $employee->email }}" required>
                                            </div>
    
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ $employee->phone_number }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="pass_wd" id="pass_wd" value="">
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="pass_wd_confirmation" id="pass_wd_confirmation" value="">
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Designation Information Section -->
                                <div class="section-container mb-5">
                                    <h5 class="section-title"><i class="fas fa-briefcase me-2"></i> Designation Information</h5>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                                <select class="form-select" id="position_data" name="position_data" required>
                                                    <option value selected disabled>Select Position</option>
                                                    @foreach ($position as $pos)
                                                        @if ($employee->position_id == $pos->id)
                                                            <option value="{{ $pos->id }}" selected>{{ $pos->position_name }}</option>
                                                        @else
                                                            <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Date of hired</label>
                                                <input type="date" class="form-control" name="doh" id="doh" value="{{ $employee->date_of_hired }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Company <span class="text-danger">*</span></label>
                                                <select class="form-select" id="company_data" name="company_data" onchange="getDepartment()" required>
                                                    <option value selected disabled>Select Company</option>
                                                    @foreach ($company as $com)
                                                        @if ($employee->company_data_id == $com->id)
                                                            <option value="{{ $com->id }}" selected>{{ $com->name }}</option>
                                                        @else
                                                            <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Department <span class="text-danger">*</span></label>
                                                <select class="form-select" id="depart_data" name="depart_data" required>
                                                    <option value selected disabled>Select Department</option>
                                                </select>
                                                <input type="hidden" name="hidden_dep" id="hidden_dep" value="{{ $employee->department_data_id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Address Section -->
                                <div class="section-container mb-4">
                                    <h5 class="section-title"><i class="fas fa-home me-2"></i> Present Address</h5>
                                    <div class="section-content">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Address 1</label>
                                                <input type="text" class="form-control" name="address1" value="{{ $employee->address1 }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Address 2</label>
                                                <input type="text" class="form-control" name="address2" value="{{ $employee->address2 }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Barangay</label>
                                                <input type="text" class="form-control" name="barangay" value="{{ $employee->barangay }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control" name="city" value="{{ $employee->city }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Province</label>
                                                <input type="text" class="form-control" name="province" value="{{ $employee->province }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" name="zip" value="{{ $employee->zip }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Country</label>
                                                <input type="text" class="form-control" name="country" value="{{ $employee->country }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-secondary me-md-2" type="button">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Update Employee</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .section-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .card-header {
            border-radius: 8px 8px 0 0 !important;
            padding: 20px 25px;
        }
        
        .form-control, .form-select {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        }
        
        .alert-info {
            background-color: #f0f7ff;
            border-color: #cce5ff;
            color: #004085;
        }
        
        .rounded-box {
            border-radius: 8px;
        }
    </style>



        <script>
            // $.$(document).ready(function () {
            //     getDepartment();
            // });
            window.onload = function () {
                getDepartment();
            };

            function getDepartment(){
                        var company_id = $('#company_data').val();
                        var hidden_dep = $('#hidden_dep').val();
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
                                    if (hidden_dep == element.id) {
                                        data_str += `<option value="${element.id}" selected>${element.name}</option>`;
                                    } else {
                                        data_str += `<option value="${element.id}">${element.name}</option>`;
                                    }
                                    
                                });
                            
                                $('#depart_data').html(data_str);
                            },
                            error: function(data) {
                                toastr.error(data.responseJSON.message);
                            }
                        });
            }
        </script>
    
</x-app-layout>