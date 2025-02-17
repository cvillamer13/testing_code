<x-app-layout>
    <x-slot name="header">
            {{ __('Permissions') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">Roles Permissions</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-responsive-sm text-center">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">No</th>
                            <th class="staff_thead_name">Roles</th>
                            <th class="staff_thead_name">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a type="button" class="btn btn-outline-success" href="/Permissions/view_edit/{{ $role->id }}" id="button_view">View</a>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</x-app-layout>