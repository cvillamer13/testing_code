<x-app-layout>
    <x-slot name="header">
            {{ __('Asset Status Report') }}
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div style="display: flex; gap: 10px; align-items: center;">
            <label for="location">Status:</label>
            <select class="form-select" id="location">
                <option value="all">All</option>
                @foreach ($asset_status as $status)
                    <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>

            <button class="btn btn-info" id="filetbtn" type="button">Filter</button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="text-center">
                    <thead>
                        <tr>
                            <th>Asset Id</th>
                            <th>Asset Description</th>
                            <th>Company</th>
                            <th class="staff_thead_edit">Department</th>
                            <th class="staff_thead_edit">Location</th>
                            <th class="staff_thead_email">Status</th>
                        </tr>
                    </thead>

                    <tbody id="asset_data">
                        @foreach ($data_asset_status as $asset_status)
                            <tr>
                                <td>{{ $asset_status->asset_id }}</td>
                                <td>{{ $asset_status->asset_description }}</td>
                                <td>{{ $asset_status->company_data->name }}</td>
                                <td>{{ $asset_status->department_data->name }}</td>
                                <td>
                                    @if (empty($asset_status->location_data->location_data2->name))
                                        <span class="badge bg-danger">No Tag Location</span>
                                    @else
                                        {{ $asset_status->location_data->location_data2->name }}
                                    @endif
                                </td>
                                <td>
                                    @if (empty($asset_status->asset_status_data->status))
                                        <span class="badge bg-danger">No status tag</span>
                                    @else
                                        {{ $asset_status->asset_status_data->status }}
                                    @endif
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

</script>


<script>
document.querySelector('#filetbtn').addEventListener('click', function() {
    let statusId = document.getElementById('location').value;

    fetch("/AssetReport/filter/assetstatus", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ status_id: statusId })
    })
    .then(response => response.json())
    .then(data => {
        let tbody = document.getElementById('asset_data');
        tbody.innerHTML = '';
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">No data found.</td></tr>';
        } else {
            data.data.forEach(asset => {
                tbody.innerHTML += `
                    <tr>
                        <td>${asset.asset_id}</td>
                        <td>${asset.asset_description}</td>
                        <td>${asset.company_data?.name ?? ''}</td>
                        <td>${asset.department_data?.name ?? ''}</td>
                        <td>
                            ${asset.location_data?.location_data2?.name 
                                ? asset.location_data.location_data2.name 
                                : '<span class="badge bg-danger">No Tag Location</span>'}
                        </td>
                        <td>
                            ${asset.asset_status_data?.status 
                                ? asset.asset_status_data.status 
                                : '<span class="badge bg-danger">No status tag</span>'}
                        </td>
                    </tr>
                `;
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>