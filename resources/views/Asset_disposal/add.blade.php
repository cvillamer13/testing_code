<x-app-layout>
    <x-slot name="header">
            {{ __('Disposal Asset') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Add Disposal Asset</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="needs-validation" action="{{ Route('AssetDisposal.add') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <h5 class="card-title">Transmitted Information</h5>
                                    
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Employee number<span class="text-red">*</span></label>
                                                    <select class="form-control" id="empp_no" name="emp_no" onchange="getTheEmployee()">
                                                        <option disabled selected>please select </option>
                                                        @foreach ($employees as $emp)
                                                            <option value="{{ $emp->id }}">{{ $emp->first_name . " " . $emp->last_name }}</option>
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
                                            
                                        </div>
                                    
                                        <button class="btn btn-primary mt-4 w-100" type="button" onclick="pre_store()">Submit</button>
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

            function pre_store(){
                const thename = document.getElementById("name_data").value;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to transmit the disposal asset to " + thename + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, add it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.querySelector("form").submit();
                    }
                })
            }

        </script>
    
</x-app-layout>