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
                                        <th class="staff_thead_email">Serial Number </th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                        <th class="staff_thead_status">Asset Assigned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asset as $ass)
                                        <tr>
                                            <td><img class="rounded-circle" width="75" height="60" src="{{ $ass->image_path == "" ? asset('images/dummy-prod-1.jpg' ): asset('storage/'.$ass->image_path )  }}" alt="image"></td>
                                            <td>{{ $ass->asset_id }}</td>
                                            <td>{{ $ass->asset_description }}</td>
                                            <td>{{ $ass->serial_number }}</td>
                                            <td>{{ $ass->asset_status_data->status ?? 'N/A' }}</td>
                                            <td><a class="badge badge-lg badge-info" id="staff_id_new" href="./edit/{{ $ass->id }}"><i class="la la-pencil"></i>View</a></td>
                                            <td><a class="badge badge-lg badge-success" data-toggle="modal" data-target="#modal_assign" id="view_assign" data-asset_id="{{ $ass->id }}"><i class="las la-eye"></i>view</a></td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_assign" tabindex="-1" role="dialog" aria-labelledby="modal_assignLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="modal_assignLabel">
                            Asset History Assigned
                        </h5>
                    </div>
                    
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <td> Asset Code </td>
                                        <td> Employee Name </td>
                                        <td>Status</td>
                                        <td>Last modified by</td>
                                        <td>Last modified at</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody_data">
                                    
                                </tbody>
                            </table>
                        </div>
                            
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


<script>
    $(document).on("click", "#view_assign", function () {
                const asset_id = $(this).attr('data-asset_id');

                $.ajax({
                    type: "POST",
                    url: "/AssetAssign/getEmpAssign",
                    data: {
                        id_asset: asset_id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        let data_tbody = '';
                        response.data.forEach(element => {
                            if (element.get_asset_data != null) {
                                data_tbody += "<tr>";
                                    data_tbody += "<td>"+element.get_asset_data.asset_id+"</td>";
                                    data_tbody += "<td>"+element.get_employee.first_name + " " + element.get_employee.last_name +"</td>";
                                    if (element.status == "TRUE") {
                                        data_tbody += '<td><span class="badge badge-lg badge-outline-success">Assigned</span></td>';
                                    } else {
                                        data_tbody += '<td><span class="badge badge-lg badge-outline-danger">UnAssigned</span></td>';
                                    }
                                    
                                    data_tbody += "<td>"+element.updatedby+"</td>";

                                    const date = new Date(element.updated_at);
                                    const options = { 
                                        weekday: 'long', // Monday
                                        year: 'numeric',  // 2011
                                        month: 'long',    // March
                                        day: 'numeric',   // 7
                                        hour: 'numeric',  // 4
                                        minute: '2-digit',// 00
                                        second: '2-digit',// 00
                                        hour12: true,     // AM/PM format
                                        timeZone: 'Asia/Manila' // Convert to Manila Time
                                    };
                                    const formattedDate = date.toLocaleString('en-US', options);

                                    data_tbody += "<td>"+formattedDate+"</td>";
                                data_tbody += "</tr>";
                            }
                            // console.log(element)
                        });

                        document.getElementById("tbody_data").innerHTML = data_tbody;
                        
                    }
                });
            })
</script>
</x-app-layout>