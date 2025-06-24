<x-app-layout>
    <x-slot name="header">
        {{ __('Asset Report') }}
    </x-slot>

    <div class="card">
        <div class="card-header">
            <!-- Header content can go here -->
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-responsive-xl text-center">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">Asset ID</th>
                            <th class="staff_thead_name">Asset Description</th>
                            <th class="staff_thead_email">Company</th>
                            <th class="staff_thead_edit">Department</th>
                            <th class="staff_thead_edit">Location</th>
                            <th class="staff_thead_edit">Status</th>
                            <th class="staff_thead_edit">Last Updated</th>
                        </tr>
                    </thead>

                    <tbody id="asset_status_data">
                        @foreach ($asset_data as $asset)
                            <tr>
                                <td>{{ $asset->asset_id }}</td>
                                <td>{{ $asset->asset_description }}</td>
                                <td>{{ $asset->company_data->name }}</td>
                                <td>{{ $asset->department_data->name }}</td>
                                <td>{{ $asset->location_data->location_data2->name ?? 'No Location' }}</td>
                                <td>{{ $asset->status }}</td>
                                <td>{{ \Carbon\Carbon::parse($asset->updated_at)->format('F d, Y h:i:s A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>