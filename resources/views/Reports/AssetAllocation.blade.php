<x-app-layout>
    <x-slot name="header">
        {{ __('Asset Allocation Report') }}
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
                            <th class="staff_thead_no">Assigned User</th>
                            <th class="staff_thead_name">Total Assigned</th>
                            <th class="staff_thead_email">Company</th>
                            <th class="staff_thead_edit">Department</th>
                        </tr>
                    </thead>

                    <tbody id="asset_status_data">
                        @foreach ($employee_data as $employee)
                            <tr>
                                <td class="staff_tbody_no">{{ $employee->first_name . " " . $employee->last_name }}</td>
                                <td class="staff_tbody_name">{{ count($employee->assetAssigned) }}</td>
                                <td class="staff_tbody_email">{{ $employee->company->name }}</td>
                                <td class="staff_tbody_edit">{{ $employee->department->name ?? 'No Department' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
