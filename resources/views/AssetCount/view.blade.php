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
                                        <th class="staff_thead_no">From</th>
                                        <th class="staff_thead_no">To</th>
                                        <th class="staff_thead_status">Count Type</th>
                                        <th class="staff_thead_status">Location</th>
                                        <th class="staff_thead_status">is Lock</th>
                                        <th class="staff_thead_status">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset_count as $data)
                                        <tr>
                                            <td>{{ $data->year }}</td>
                                            <td>{{ $data->date_from }}</td>
                                            <td>{{ $data->date_to }}</td>
                                            <td>
                                                @if ($data->type == 'quarter')
                                                    Quarter
                                                @else
                                                    Count
                                                @endif
                                            </td>
                                            <td>{{ $data->location_show->location_data->name }}</td>
                                                
                                            </td>
                                            <td>
                                                @if ($data->is_finalized == 1)
                                                    <span class="badge badge-success">Yes</span>
                                                @else
                                                    <span class="badge badge-danger">No</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ url('/AssetCount/for_finalize/' . $data->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{ url('/AssetCount/delete/' .$data->id) }}" class="btn btn-danger btn-sm">Delete</a>
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