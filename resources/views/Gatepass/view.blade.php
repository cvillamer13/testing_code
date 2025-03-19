<x-app-layout>
    <x-slot name="header">
            {{ __('Gatepass') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Gatepass</h4>
                        {{-- <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Gatepass
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div> --}}
                    </div>

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_no">Gatepass No</th>
                                        <th class="staff_thead_name">Issued by</th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dat)
                                        <tr>
                                            <td><</td>
                                            <td>{{ $dat->gatepass_no }}</td>
                                            <td>{{ $ass->iss }}</td>
                                            <td>{{ $ass->status }}</td>
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


<script>
</script>
</x-app-layout>