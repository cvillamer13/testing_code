<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Count') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Asset Count</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Asset Count
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
                                        <th class="staff_thead_no">Year</th>
                                        <th class="staff_thead_status">Count Type</th>
                                        <th class="staff_thead_status">Location</th>
                                        <th class="staff_thead_status">is Lock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assetCounts as $assetCount)
                                        <tr>
                                            <td>{{ $assetCount->year }}</td>
                                            <td>{{ $assetCount->count_type }}</td>
                                            <td>{{ $assetCount->location }}</td>
                                            <td>{{ $assetCount->is_lock ? 'Yes' : 'No' }}</td>
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