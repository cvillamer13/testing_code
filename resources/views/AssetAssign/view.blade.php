<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Issuance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset Issuance</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Asset Issuance
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
                                        <th class="staff_thead_no">Revised No</th>
                                        <th class="staff_thead_status">Status</th>
                                        <th class="staff_thead_status">Action</th>
                                        <th class="staff_thead_status">Gatepass</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset_issuance as $issu)
                                    <tr>
                                        <td class="position-relative">
                                            {{ $issu->rev_num }}
                                            {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                Pending
                                            </span> --}}
                                        </td>
                                        <td> 
                                            @if ($issu->status == 'A')
                                                <div class="alert alert-success" role="alert">
                                                    Approved
                                                </div>
                                                
                                            @elseif($issu->status == 'R')
                                                <div class="alert alert-danger" role="alert">
                                                    Rejected
                                                </div>
                                            @else
                                                <div class="alert alert-info" role="alert">
                                                    Pending
                                                </div>
                                            @endif
                                        </td>
                                        <td> 
                                            <a class="btn btn-outline-info" href="/AssetAssign/detl/{{ $issu->id }}">View</a>
                                        </td>
                                        <td> 
                                            <a class="btn btn-outline-warning" href="/AssetAssign/detl/{{ $issu->id }}">View</a>
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