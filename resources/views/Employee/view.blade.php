<x-app-layout>
    <x-slot name="header">
            {{ __('Employee Maintenance') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    <div class="card-header">
                        <h4 class="card-title col-6">List of Employees</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Employee
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_no">Employee Number</th>
                                        <th class="staff_thead_name">Full Name</th>
                                        <th class="staff_thead_email">Email </th>
                                        <th class="staff_thead_status">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->emp_no }}</td>
                                            <td>{{ $employee->first_name . " " . $employee->last_name }}</td>
                                            <td>{{ $employee->email }}</td>
                                            <td>
                                                <span class="badge badge-lg badge-outline-success">Active</span>
                                                <span class="badge badge-lg badge-outline-danger">Resigned</span>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    
</x-app-layout>