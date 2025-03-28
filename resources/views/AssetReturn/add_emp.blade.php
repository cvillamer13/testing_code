<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Return') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Add Asset Return</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                <span class="text-red">*</span> - <b>Required</b>
                                <hr>
                                <form class="needs-validation" action="{{ Route('AssetReturn.add_emplyee') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    {{-- <label class="form-label">Employee number<span class="text-red">*</span></label> --}}
                                                    {{-- <input type4="text" class="form-control" name="emp_no" id="emp_no" required> --}}
                                                    <select class="form-select" name="emp_id" id="emp_id">
                                                        <option selected disabled>please select</option>
                                                        @foreach ($emp_data as $emp)
                                                            <option value="{{ $emp->id }}">{{ $emp->first_name . ' ' . $emp->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="selected_id" id="selected_id" value="">
                                            <table width="100%" style="border-collapse: collapse;">
                                                <tr>
                                                    <!-- Left Section -->
                                                    <td align="left" style="vertical-align: top;">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Number: <span class="text-black" id="emp_number"></span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Name: <span class="text-black" id="emp_name"></span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Company: <span class="text-black" id="emp_company"></span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Department: <span class="text-black" id="emp_department"></span></label> 
                                                            </div>
                                                        </div>
                                                    </td>
                                            
                                                    <!-- Right Section -->
                                                    <td align="right" style="vertical-align: top;">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="">Date Hired: <span class="text-black" id="emp_hiring_date"></span></label> 
                                                            </div>
                                                            <div class="mb-10">
                                                                <label class="">Date Separation: <input type="date" class="form-control" name="date_sep" id="date_sep"></label> 
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            
                                            
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

            $(document).ready(function () {
                $('#emp_id').change(function () {
                    // alert("Hello"); // Debugging step
                    const data_id = $(this).val();
                    Swal.fire({
                            title: "Processing...",
                            text: "Please wait while the fetching details.",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                                $.ajax({
                                    type: "POST",
                                    url: "/Employee_DB/getEmployee",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "id": data_id
                                    },
                                    success: function (response) {
                                        const data_emp = response.emp_no ?? "N/A";
                                        const data_name = response.first_name + " " + response.last_name  ?? "N/A";
                                        const data_company = response.company.name ?? "N/A";
                                        const data_department = response.department.name ?? "N/A";
                                        const data_datehired = response.date_of_hired == "" ? "N/A" : response.date_of_hired;
                                        // document.getElementbyId("emp_number").innerHTML = data_emp
                                        $('#emp_number').text(data_emp);
                                        $('#emp_name').text(data_name);
                                        $('#emp_company').text(data_company);
                                        $('#emp_department').text(data_department);
                                        $('#emp_hiring_date').text(data_datehired);

                                        $('#selected_id').val(response.id);

                                        // console.log(response);
                                        Swal.close();
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("AJAX Error:", error);
                                    }
                                });
                            }
                    })
                    
                });
            });


        </script>
    
</x-app-layout>