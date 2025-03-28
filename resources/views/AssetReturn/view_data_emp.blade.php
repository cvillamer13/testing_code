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
                                <h1>{{ $status->ref }}</h1>
                                <hr>
                                {{-- <form class="needs-validation" action="/AssetReturn/finalize" method="post" enctype="multipart/form-data"> --}}
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <input type="hidden" name="aset_return_id" id="aset_return_id" value="{{ $status->id }}">
                                            <input type="hidden" name="selected_id" id="selected_id" value="">
                                            <table width="100%" style="border-collapse: collapse;">
                                                <tr>
                                                    <!-- Left Section -->
                                                    <td align="left" style="vertical-align: top;">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Number: <span class="text-black" id="emp_number">{{ $status->employee_data->emp_no}}</span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Employee Name: <span class="text-black" id="emp_name">{{ $status->employee_data->first_name . " " . $status->employee_data->last_name }}</span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Company: <span class="text-black" id="emp_company">{{ $status->employee_data->company->name }}</span></label> 
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Department: <span class="text-black" id="emp_department">{{ $status->employee_data->department->name }}</span></label> 
                                                            </div>
                                                        </div>
                                                    </td>
                                            
                                                    <!-- Right Section -->
                                                    <td align="right" style="vertical-align: top;">
                                                        <div>
                                                            <div class="mb-3">
                                                                <label class="">Date Hired: <span class="text-black" id="emp_hiring_date">{{ $status->employee_data->date_of_hired }}</span></label> 
                                                            </div>
                                                            <div class="mb-10">
                                                                <label class="">Date Separation: <span class="text-black" id="emp_hiring_date">{{ $status->separate_date }}</span> </label> 
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            
                                            
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-xl-12">

                                            <input type="hidden" name="selected_id" id="selected_id" value="">
                                            <table id="example2" class="table table-responsive-sm text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Asset ID</th>
                                                        <th>Asset Description</th>
                                                        <th>Serial No</th>
                                                        <th>Clear</th>
                                                        <th>Not Applicable</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detl_data as $detl)
                                                        <tr>
                                                            <td>{{ $detl->asset_detls->asset_id }}</td>
                                                            <td>{{ $detl->asset_detls->asset_description }}</td>
                                                            <td>{{ $detl->asset_detls->serial_number }}</td>
                                                            <td class="text-center"> <input type="checkbox"  name="isClear" value="1" <?php echo ($detl->isClear) ? 'checked' : ''; ?> readonly disabled> </td>
                                                            <td class="text-center"> <input type="checkbox" name="isClear" value="1" <?php echo ($detl->is_not_applicable) ? 'checked' : ''; ?> readonly disabled> </td>
                                                            <td>{{ $detl->remarks }}</td>
                                                        </tr>
                                                    @endforeach
                                                    
                                                </tbody>
                                                
                                            </table>
                                            
                                            
                                        </div>
                                    </div>
                                        @if (!$status->is_finalized)
                                            <button class="btn btn-primary mt-4 w-100" onclick="final_data()" type="submit">Finalize</button>
                                        @else
                                            <hr>
                                            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;" class="text-center">
                                                <tr>
                                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Confirmed by</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">UID</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Date</th>
                                                </tr>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $status->confirmed_by }}</td>
                                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $status->confirmed_uid }}</td>
                                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $status->confirmed_at }}</td>
                                                </tr>
                                            </table>
                                            
                                            
                                        @endif
                                        
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function final_data(){
                Swal.fire({
                    title: "Do you want to finalized the asset return?",
                    text: "Once finalized, you will no longer be able to make changes or send the request for checking.",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Finalize",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var id = document.getElementById("aset_return_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/AssetReturn/finalize",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "id_return_main": id
                        },
                        success: function (response) {
                            swal.close();
                            toastr.success(response.message);
                            location.reload();
                        },
                        error: function (error) {
                            console.log(error)
                            toastr.error("Error: " + error.responseJSON.message);
                        }
                    });
                    
                    // Swal.fire("Saved!", "", "success");
                    
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
                });

            }

        </script>
    
</x-app-layout>