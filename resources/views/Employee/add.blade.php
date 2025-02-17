<x-app-layout>
    <x-slot name="header">
            {{ __('Employee Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Add Employees</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                <center><span class="text-red">*</span> - <b>Required</b></center>
                                <br>
                                <form class="needs-validation" action="{{ Route('employee.add') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="card-title">Basic Information</h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Employee number<span class="text-red">*</span></label>
                                                    <input type4="text" class="form-control" name="emp_no" id="emp_no" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">First Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="f_name" id="f_name" required>
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Last Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Date of birth</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Gender<span class="text-red">*</span></label>
                                                    <select class="form-control" id="gender_data" name="gender_data">
                                                        <option value selected disabled> Please Choose</option>
                                                        @foreach ($gender as $gen)
                                                            <option value="{{ $gen->id }}">{{ $gen->gender_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Email<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Phone Number<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>


                                            <h5 class="card-title">Disgnation Information</h5>
                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Position <span class="text-red">*</span></label>
                                                    <select class="form-control" id="position_data" name="position_data" required>
                                                        <option value selected disabled> Please Choose</option>
                                                        @foreach ($position as $pos)
                                                            <option value="{{ $pos->id }}">{{ $pos->position_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Company<span class="text-red">*</span></label>
                                                    <select class="form-control" id="company_data" name="company_data" required>
                                                        <option value selected disabled> Please Choose</option>
                                                        @foreach ($company as $com)
                                                            <option value="{{ $com->id }}">{{ $com->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Department<span class="text-red">*</span></label>
                                                    <select class="form-control" id="depart_data" name="depart_data" required>
                                                        <option value selected disabled> Please Choose</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="card p-3 mt-3">
                                                <h5 class="card-title">Present Address</h5>
                                                <div class="row">
                                                    <!-- Street Address -->
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Address 1</label>
                                                        <input type="text" class="form-control" name="street">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Address 2</label>
                                                        <input type="text" class="form-control" name="street">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- City -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">City</label>
                                                        <input type="text" class="form-control" name="city">
                                                    </div>

                                                    <!-- State -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Province</label>
                                                        <input type="text" class="form-control" name="state">
                                                    </div>

                                                    <!-- Zip Code -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Zip Code</label>
                                                        <input type="text" class="form-control" name="zip">
                                                    </div>

                                                    <!-- Country -->
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label">Country</label>
                                                        <input type="text" class="form-control" name="country">
                                                    </div>
                                                </div>
                                            </div>

                                            
                                               
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function getDepartment(){
                        var company_id = $('#company_data').val();
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
                            
                                $('#depart_data').html(data_str);
                            },
                            error: function(data) {
                                toastr.error(data.responseJSON.message);
                            }
                        });
            }
        </script>
    
</x-app-layout>