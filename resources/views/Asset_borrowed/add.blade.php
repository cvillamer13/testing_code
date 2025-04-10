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
                                <form class="needs-validation" action="{{ Route('BorrowedAsset.add') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="card-title">Assignee Information</h5>
                                    
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Employee number<span class="text-red">*</span></label>
                                                    <select class="form-control" id="empp_no" name="emp_no" onchange="getTheEmployee()">
                                                        <option disabled selected>please select </option>
                                                        @foreach ($employee as $emp)
                                                            <option value="{{ $emp->id }}">{{ $emp->emp_no." : ".$emp->first_name." ".$emp->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name_data" value="" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Designation</label>
                                                    <input type="text" class="form-control" id="position_data"  value="" readonly disabled>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Business unit</label>
                                                    <input type="text" class="form-control" id="company_data"  value="" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Department</label>
                                                    <input type="text" class="form-control" id="department_data"  value="" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email_data"  value="" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone_data"  value="" readonly disabled>
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
                                                        <td>{{ $mis->company->name }}</td>
                                                        <td>{{ $mis->department->name }}</td>
                                                        <td>{{ $mis->name }}</td>
                                                        <td>
                                                            <select class="form-control" id="to_company" name="to_company" onchange="getDepartment();">
                                                                <option value="" selected readonly disabled>please select</option>
                                                                @foreach ($to_company as $tcompany)
                                                                    <option value="{{ $tcompany->id }}">{{ $tcompany->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" id="to_department" name="to_department" onchange="getLocation()">
                                                                <option readonly disabled>please select</option>

                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" id="to_location" name="to_location">

                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Date Requested</label>
                                                    <input type="date" class="form-control" id="date_requested" name="date_requested" value="{{ Carbon\Carbon::now()->toDateString() }}" readonly>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Deployed Date</label>
                                                    <input type="date" class="form-control" id="date_need" name="date_need"  value="">
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="mb-3 col-md-12">
                                                    <label class="form-label">Ref. RSS Ticket Numbers</label>
                                                    <input type="text" class="form-control" id="rss_num" name="rss_num"  value="">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Submit</button>
                                </form>
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
                                data_str += `<option value="${element.id}">${element.location_data.name}</option>`;
                            });
                            $('#to_location').html(data_str);
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                        }
                    });
            }

        </script>
    
</x-app-layout>