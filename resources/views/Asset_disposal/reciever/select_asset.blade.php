<x-guest-layout>
    <x-slot name="header">
            {{ __('Asset Disposal') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">Recieved Asset Disposal</h4>
                    </div>
                    <div class="card py-3 px-3">
                        <div class="card-body">
                            <div class="form-validation">
                                {{-- <form class="needs-validation" action="/BorrowedAsset/for_finalize/{{ $data->id }}" method="post" enctype="multipart/form-data"> --}}
                                    @csrf
                                    <h5 class="card-title">{{ $data->ref_num }}</h5>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Employee number</label>
                                                    <input type="text" class="form-control" id="name_data" value="{{ $data->transmitted_emp->emp_no }}" readonly disabled>
                                                    <input type="hidden" id="emp_id" value="{{ $data->transmitted_emp->id }}">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name_data" value="{{ $data->transmitted_emp->first_name . ' ' . $data->transmitted_emp->last_name  }}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Designation</label>
                                                    <input type="text" class="form-control" id="position_data"  value="{{ $data->transmitted_emp->position->position_name  }}" readonly disabled>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Business unit</label>
                                                    <input type="text" class="form-control" id="company_data"  value="{{ $data->transmitted_emp->company->name  }}" readonly disabled>
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Department</label>
                                                    <input type="text" class="form-control" id="department_data"  value="{{ $data->transmitted_emp->department->name  }}" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email_data"  value="{{ $data->transmitted_emp->email  }}" readonly disabled>
                                                </div>

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone_data"  value="{{ $data->transmitted_emp->phone_number }}" readonly disabled>
                                                </div>
                                                
                                            </div>
                                            


                                            <hr>
                                            <h5 class="card-title">Dispose Asset</h5>
                                                @php
                                                    if($data->is_finalized){
                                                        $view_table="data_notselected";
                                                    }else{
                                                        $view_table="data_selected";
                                                    }
                                                @endphp
                                                <table class="table text-center" id="{{ $view_table }}">
                                                    <thead>
                                                        <tr>
                                                            <th>Asset Tag</th>
                                                            <th>Asset Description</th>
                                                            <th>Asset Model</th>
                                                            <th>Serial No</th>
                                                            <th>Remarks</th>
                                                            <th>Qty</th>
                                                            <th>Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $x = 0;
                                                        @endphp

                                                        @foreach ($data->details as $assetdetl)
                                                        <tr>
                                                            <td>{{ $assetdetl->asset_details->asset_id }}</td>
                                                            <td>{{ $assetdetl->asset_details->asset_description }}</td>
                                                            <td>{{ $assetdetl->asset_details->model_no }}</td>
                                                            <td>{{ $assetdetl->asset_details->serial_number }}</td>
                                                            <td>{{ $assetdetl->remarks }}</td>
                                                            <td>{{ $assetdetl->qty }}</td>
                                                            <td>{{ $assetdetl->unit }}</td>
                                                        </tr>
                                                            
                                                        @endforeach
                                                        
                                                        <input type="hidden" id="last_count_data" value="{{ $x }}">
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <input type="hidden" name="asset_disposal_id" id="asset_disposal_id" value="{{ $data->id }}">
                                        @if ($data->is_finalized)
                                        <div class="row">
                                            <h5 class="card-title">Approvers</h5>
                                            <hr>
                                            @foreach ($disposal_status as $disposed)
                                            <div class="mb-3 col-sm-4 text-center">
                                                <label for="employee_name" class="form-label"><b>{{  $disposed->user->name }}</b></label>
                                                @if (!is_null($disposed->uid) > 0)
                                                    <p>uid: {{  $disposed->uid }}</p>
                                                @endif

                                                @if (!is_null($disposed->remarks) > 0)
                                                    <p>Reason: {{  $disposed->remarks }}</p>
                                                @endif
                                                {{-- <p>uid: {{  $data->uid }}</p> --}}
                                                <br>

                                                
                                                <label for="employee_name" class="form-label">
                                                        
                                                    @switch($disposed->status)
                                                        @case('P')
                                                            <div class="alert alert-info" role="alert">
                                                                Pending
                                                            </div>
                                                            @break
                                                        @case('NA')
                                                            <div class="alert alert-primary" role="alert">
                                                                Waiting for Approval
                                                            </div>
                                                            @break
                                                        @case('A')
                                                            <div class="alert alert-success" role="alert">
                                                                Approved
                                                            </div>
                                                            @break
                                                        @case('R')
                                                            <div class="alert alert-danger" role="alert">
                                                                Rejected
                                                            </div>
                                                            @break
                                                        @case('CNA')
                                                            <div class="alert alert-warning" role="alert">
                                                                Cancelled because of last approver is rejected
                                                            </div>
                                                            @break
                                                        @default
                                                            Unknown Status
                                                    @endswitch
                                                
                                                </label>
                                                    
                                                
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        
                                {{-- </form> --}}
                                @if ($data->is_recieved)
                                    <div class="alert alert-success text-center" role="alert">
                                        Recieved By: {{ $data->recieved_by->first_name . " " . $data->recieved_by->last_name  }} at {{ $data->recieved_at }}
                                    </div>
                                @else
                                    <button class="btn btn-primary mt-4 w-100" type="button" onclick="final_data()">Recieved</button>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>

            
            function final_data(){
                Swal.fire({
                    title: "Do you want to finalized the Asset disposal?",
                    text: "Once Recieved, you will not be able to make changes.",
                    icon: "warning",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Recieved",
                    denyButtonText: `Cancel`
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.showLoading();
                    var main_id = document.getElementById("asset_disposal_id").value;
                    var emp_id = document.getElementById("emp_id").value;
                    $.ajax({
                        type: "POST",
                        url: "/AssetDisposal/received",
                        data: {
                            "_token": '{{ csrf_token() }}',
                            "asset_disposal_id": main_id,
                            "emp_id" : emp_id
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
    
</x-guest-layout>