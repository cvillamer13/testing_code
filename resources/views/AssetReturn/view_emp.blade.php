<x-app-layout>
<x-slot name="header">
        {{ __('Asset Returned') }}
</x-slot>
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-xl-12">
                <div class="card-header">
                    <h4 class="card-title col-6">List of Asset Returned</h4>
                    <div class="card-title col-6 text-end">
                        <a class="btn btn-rounded btn-info" href="./add_emp" id="scanned_start">
                            Request Asset Returned
                            <span class="btn-icon-start text-info"><i
                                    class="fa fa-plus color-info"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <input type="text" id="barcodeInput" style="position: absolute; left: -9999px;" autocomplete="off">
                <div class="card py-3 px-3">
                <div class="settings-form">
                    <div class="table-responsive">
                        <table id="example2" class="table table-responsive-sm text-center">
                            <thead>
                                <tr>
                                    <th>REQUEST ID</th>
                                    <th>REQUEST DATE</th>
                                    <th>REQUEST STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_data">
                                @foreach ($status as $stat)
                                    <tr>
                                        <td>{{ $stat->ref }}</td>
                                        <td>{{ $stat->created_at }}</td>
                                
                                        <td> 
                                            @if ($stat->status == 'A')
                                                <div class="alert alert-success" role="alert">
                                                    Approved
                                                </div>
                                                
                                            @else
                                                <div class="alert alert-info" role="alert">
                                                    Pending
                                                </div>
                                            @endif
                                        </td>
                                        <td><a class="btn btn-outline-info" href="/AssetReturn/view_data_emp/{{ $stat->id }}">View</a></td>
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
</x-app-layout>