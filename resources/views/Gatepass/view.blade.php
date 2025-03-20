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
                                        <th class="staff_thead_status">Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dat)
                                        <tr>
                                            <td>{{ $dat->gatepass_no }}</td>
                                            <td>{{ $dat->finalizedby }}</td>
                                            <td>{{ $dat->approved_status == "A" ? "APPROVED" : "PENDING" }}</td>
                                            <td><a class="badge badge-lg badge-info" id="staff_id_new" href="./data/{{ $dat->id }}"><i class="la la-pencil"></i>View</a></td>
                                            <td><a class="badge badge-lg badge-warning" href="/Gatepass/gatepass_report/{{ $dat->id }}" target="_blank"><i class="las la-eye"></i>Print</a></td>
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