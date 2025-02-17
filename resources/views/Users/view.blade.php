<x-app-layout>
    <x-slot name="header">
            {{ __('User Management') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">All Users</h4>
            <div class="card-title col-6 text-end">
                <a class="btn btn-rounded btn-info" href="/User/add" data-target="#exampleModal">
                    Add User
                    <span class="btn-icon-start text-info"><i
                            class="fa fa-plus color-info"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">Image</th>
                            <th class="staff_thead_name">Name</th>
                            <th class="staff_thead_email">Email </th>
                            <th class="staff_thead_mobile">Role</th>
                            <th class="staff_thead_status">Status</th>
                            <th class="staff_thead_edit">Edit</th>
                            {{-- <th class="staff_thead_login"><%= language.login %></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><img class="rounded-circle" width="75" height="60" src="{{ asset('storage/'.$user->image_path) }}" alt="image"></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    @if ($user->active_status == 1)
                                        <span class="badge badge-lg badge-outline-success">Active</span>
                                    @else
                                        <span class="badge badge-lg badge-outline-danger">inactive</span>
                                    @endif
                                    {{-- <span class="badge badge-lg badge-outline-info">Active</span>
                                    <span class="badge badge-lg badge-outline-danger">inactive</span> --}}
                                </td>
                                <td class="staff_tbody_edit">
                                        <a class="badge badge-lg badge-info" id="staff_id_new" href="/User/edit/{{ $user->id }}"><i class="la la-pencil"></i>Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>