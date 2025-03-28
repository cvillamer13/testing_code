<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Transfer') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset Transfer</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" id="scanned_start" href="./add">
                                Add Asset Transfer
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
                                            <th class="staff_thead_no">Issuance No.</th>
                                            <th class="staff_thead_name">Request By</th>
                                            <th class="staff_thead_name">Status</th>
                                            <th class="staff_thead_name">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $dat)
                                            <tr>
                                                <td>{{ $dat->from_issuance }}</td>
                                                <td>{{ $dat->requested_by }}</td>
                                                <td>
                                                    @switch($dat->approved_status)
                                                        @case("A")
                                                            <div class="alert alert-success" role="alert">
                                                                Approved
                                                            </div>
                                                        @break

                                                        @case("P")
                                                            <div class="alert alert-warning" role="alert">
                                                                Pending
                                                            </div>
                                                        @break

                                                        @case("R")
                                                            <div class="alert alert-danger" role="alert">
                                                                Rejected
                                                            </div>
                                                        @break
                                                    
                                                        @default
                                                            
                                                    @endswitch
                                                    
                                                    
                                                </td>
                                                <td>
                                                    <a class="btn btn-outline-info" href="/AssetTransfer/finalize/{{ $dat->id }}">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
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