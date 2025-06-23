<style>
    .data_scanned {
        color: green ;
    }

    .data_not_scanned {
        color: red ;
    }
</style>
<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Scanned Report') }}
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div style="display: flex; gap: 10px; align-items: center;">
            <label for="location">Location:</label>
            <select class="form-select" id="location">
                <option value="all">All</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>

            <label for="date_from">Date From:</label>
            <input type="date" class="form-control" id="date_from">

            <label for="date_to">Date To:</label>
            <input type="date" class="form-control" id="date_to">

            <label for="scan_status">Scan Status:</label>
            <select id="scan_status" class="form-select">
                <option value="all">All</option>
                <option value="scanned">Scanned</option>
                <option value="not_scanned">Not Scanned</option>
            </select>

            <button class="btn btn-info" type="button">Filter</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="text-center">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">Asset Id</th>
                            <th class="staff_thead_name">Asset Description</th>
                            <th class="staff_thead_edit">Company</th>
                            <th class="staff_thead_edit">Department</th>
                            <th class="staff_thead_edit">Location</th>
                            <th class="staff_thead_email">Scanned Date</th>
                            <th class="staff_thead_edit">Scanned Time</th>
                            <th class="staff_thead_edit">Scanned By</th>
                        </tr>
                    </thead>

                    <tbody id="asset_data">
                        @foreach ($asset_data as $asset)
                            @if ($asset->asset_scanned_data->isNotEmpty())
                                <tr class="data_scanned">
                                    <td>{{ $asset->asset_id }}</td>
                                    <td>{{ $asset->asset_description }}</td>
                                    <td>{{ $asset->company_data->name }}</td>
                                    <td>{{ $asset->department_data->name }}</td>
                                    <td>{{ $asset->location_data->location_data2->name ?? 'No Location' }}</td>
                                    
                                    <td>
                                        @if ($asset->asset_scanned_data->isNotEmpty())
                                        {{ \Carbon\Carbon::parse($asset->asset_scanned_data->sortByDesc('scanned_date')->first()->scanned_date)->format('F d, Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($asset->asset_scanned_data->isNotEmpty())
                                        {{ \Carbon\Carbon::parse($asset->asset_scanned_data->sortByDesc('scanned_time')->first()->scanned_time)->format('h:i:s A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($asset->asset_scanned_data->isNotEmpty())
                                        {{ $asset->asset_scanned_data->sortByDesc('scanned_time')->first()->createdby }}
                                        @endif
                                    </td>
                                </tr>
                            @else
                                <tr class="data_not_scanned">
                                        <td>{{ $asset->asset_id }}</td>
                                        <td>{{ $asset->asset_description }}</td>
                                        <td>{{ $asset->company_data->name }}</td>
                                        <td>{{ $asset->department_data->name }}</td>
                                        <td>{{ $asset->location_data->location_data2->name ?? 'No Location' }}</td>
                                        
                                        <td>
                                            @if ($asset->asset_scanned_data->isNotEmpty())
                                                {{ \Carbon\Carbon::parse($asset->asset_scanned_data->sortByDesc('scanned_date')->first()->scanned_date)->format('F d, Y') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($asset->asset_scanned_data->isNotEmpty())
                                                {{ \Carbon\Carbon::parse($asset->asset_scanned_data->sortByDesc('scanned_time')->first()->scanned_time)->format('h:i:s A') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($asset->asset_scanned_data->isNotEmpty())
                                                {{ $asset->asset_scanned_data->sortByDesc('scanned_time')->first()->createdby }}
                                            @endif
                                        </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
       

        // Filter button click event
        $('.btn-info').on('click', function() {
            var location = $('#location').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            var scan_status = $('#scan_status').val();
            var _token = '{{ csrf_token() }}';

            $.ajax({
            url: '/AssetReport/filter/asset_scanned',
            type: 'POST',
            data: {
                location: location,
                date_from: date_from,
                date_to: date_to,
                scan_status: scan_status,
                _token: _token
            },
            success: function(response) {
                // Replace table body with new data
                $('#asset_data').empty();
                let tbody = '';
                // $.each(response.data, function (index, data_value) { 
                //     console.log(data_value);
                // });

                $.each(response.data, function(index, asset) {
                    if (asset.asset_scanned_data.length > 0) {
                        tbody += '<tr class="data_scanned">';
                    } else {
                        tbody += '<tr class="data_not_scanned">';
                    }
                    tbody += '<td>' + asset.asset_id + '</td>';
                    tbody += '<td>' + asset.asset_description + '</td>';
                    tbody += '<td>' + asset.company_data.name + '</td>';
                    tbody += '<td>' + asset.department_data.name + '</td>';
                    tbody += '<td>' + asset.department_data.name + '</td>';
                    // tbody += '<td>' + (asset.location_data.location_data2 ? asset.location_data.location_data2.name : 'No Location') + '</td>';
                    
                    if (asset.asset_scanned_data.length > 0) {
                        var lastScan = asset.asset_scanned_data.sort((a, b) => new Date(b.scanned_date) - new Date(a.scanned_date))[0];
                        tbody += '<td>' + new Date(lastScan.scanned_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) + '</td>';
                        tbody += '<td>' + new Date(lastScan.scanned_time).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }) + '</td>';
                        tbody += '<td>' + lastScan.createdby + '</td>';
                    } else {
                        tbody += '<td></td><td></td><td></td>';
                    }
                    
                    tbody += '</tr>';
                });
                console.log(tbody)
                $('#asset_data').html(tbody);
                
            },
            error: function(xhr) {
                alert('An error occurred while filtering data.');
            }
            });
        });

        // Optional: trigger filter on Enter key in any filter input
        // $('#location, #date_from, #date_to, #scan_status').on('keypress', function(e) {
        //     if (e.which === 13) {
        //         table.ajax.reload();
        //     }
        // });
    });
</script>