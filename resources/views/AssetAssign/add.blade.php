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
                                <form class="needs-validation" action="{{ Route('AssetAssign.add') }}" method="post" enctype="multipart/form-data">
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
                                                    <label class="form-label">Reports To<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" id="reports_to" name="reports_to" value="">
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Location<span class="text-red">*</span></label>
                                                    {{-- <input type="text" class="form-control" id="location_id" name="location_id"  value=""> --}}
                                                    <select class="form-control" id="location_id" name="location_id">
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
                                            
                                            

                                            <hr>
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

        </script>
    
</x-app-layout>