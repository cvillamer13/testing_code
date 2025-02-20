<x-app-layout>
    <x-slot name="header">
            {{ __('Employee Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Edit Employees</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                <center><span class="text-red">*</span> - <b>Required</b></center>
                                <br>
                                <form class="needs-validation" action="/Employee_DB/edit/{{ $employee->id }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="card-title">Basic Information</h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Employee number<span class="text-red">*</span></label>
                                                    <input type4="text" class="form-control" name="emp_no" id="emp_no" value="{{ $employee->emp_no }}" readonly required>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Upload Profile Picture</label>
                                                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <img class="rounded-box" width="200" src="{{ asset('storage/'.$employee->image_path) }}" alt="image">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">First Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="f_name" id="f_name" value="{{ $employee->first_name }}" required>
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" name="m_name" id="m_name" value="{{ $employee->middle_name }}">
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Last Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="l_name" id="l_name" value="{{ $employee->last_name }}" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Date of birth</label>
                                                    <input type="date" class="form-control" name="dob" id="dob" value="{{ $employee->date_of_birth }}">
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Gender<span class="text-red">*</span></label>
                                                    <select class="form-control" id="gender_data" name="gender_data">
                                                        <option value selected disabled> Please Choose</option>
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
                                                    <label class="form-label">Email<span class="text-red">*</span></label>
                                                    <input type="email" class="form-control" name="email_data" id="email_data" value="{{ $employee->email }}" required>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Phone Number<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ $employee->phone_number }}" required>
                                                </div>
                                            </div>


                                            <h5 class="card-title">Designation Information</h5>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Position <span class="text-red">*</span></label>
                                                    <select class="form-control" id="position_data" name="position_data" required>
                                                        <option value selected disabled> Please Choose</option>
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
                                                    <label class="form-label">Company<span class="text-red">*</span></label>
                                                    <select class="form-control" id="company_data" name="company_data" onchange="getDepartment()" required>
                                                        <option value selected disabled> Please Choose</option>
                                                        @foreach ($company as $com)
                                                            {{-- <option value="{{ $com->id }}">{{ $com->name }}</option> --}}
                                                            @if ($employee->company_data_id == $com->id)
                                                                <option value="{{ $com->id }}" selected>{{ $com->name }}</option>
                                                            @else
                                                                <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Department<span class="text-red">*</span></label>
                                                    <select class="form-control" id="depart_data" name="depart_data" required>
                                                        <option value selected disabled> Please Choose</option>
                                                    </select>
                                                    <input type="hidden" name="hidden_dep" id="hidden_dep" value="{{ $employee->department_data_id }}">
                                                </div>
                                            </div>
                                                <h5 class="card-title">Present Address</h5>
                                                <div class="row">
                                                    <!-- Street Address -->
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
                                                    <!-- City -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">City</label>
                                                        <input type="text" class="form-control" name="city" value="{{ $employee->city }}">
                                                    </div>

                                                    <!-- State -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Province</label>
                                                        <input type="text" class="form-control" name="province" value="{{ $employee->province }}">
                                                    </div>

                                                    <!-- Zip Code -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Zip Code</label>
                                                        <input type="text" class="form-control" name="zip" value="{{ $employee->zip }}">
                                                    </div>

                                                    <!-- Country -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Country</label>
                                                        <input type="text" class="form-control" name="country" value="{{ $employee->country }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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