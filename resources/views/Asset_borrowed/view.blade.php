<x-app-layout>
    <x-slot name="header">
            {{ __('Borrowed Asset') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Borrowed Asset</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Borrowed Asset
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
                                        <th class="staff_thead_no">No</th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                        <th class="staff_thead_status">Gatepass</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $da)
                                        <tr>
                                            <td>{{ $da->ref_num }}</td>
                                            <td>
                                                @if ($da->status== 'A')
                                                    <div class="alert alert-success" role="alert">
                                                        Approved
                                                    </div>
                                                    
                                                @elseif($da->status == 'R')
                                                    <div class="alert alert-danger" role="alert">
                                                        Rejected
                                                    </div>
                                                @elseif($da->status == 'RE')
                                                    <div class="alert alert-danger" role="alert">
                                                        Revised
                                                    </div>
                                                @else
                                                    <div class="alert alert-info" role="alert">
                                                        Pending
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-info" href="/BorrowedAsset/for_finalize/{{ $da->id }}">View</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-warning" href="/BorrowedAsset/gate_passchecker/{{ $da->id }}" target="_blank">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</x-app-layout>