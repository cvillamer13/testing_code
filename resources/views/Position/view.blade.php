<x-app-layout>
    <x-slot name="header">
            {{ __('Designation Maintenance') }}
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">All Position</h4>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target="#addPositionModal">
                    Add Position
                    <span class="btn-icon-start text-info">
                        <i class="fa fa-plus color-info"></i>
                    </span>
                </button>
            </div>

            <!-- Add Position Modal -->
            <div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="addPositionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPositionModalLabel">Add Position</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="position_name">Position Name</label>
                                    <input type="text" class="form-control" id="position_name" name="position_name" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Position</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 900px; overflow-y: auto;">
                <table id="example" class="table table-responsive-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th class="staff_thead_no">No</th>
                            <th class="staff_thead_name">Position</th>
                            <th class="staff_thead_name">Action</th>
                            <th class="staff_thead_name">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postions as $position)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $position->position_name }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $position->id }}">
                                        Edit
                                    </button>
                                </td>
                                <td>
                                    <form action="" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this position?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @foreach ($postions as $position)
        <div class="modal fade" id="editModal-{{ $position->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $position->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $position->id }}">Edit Position</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="position_name_{{ $position->id }}">Position Name</label>
                                <input type="text" class="form-control" id="position_name_{{ $position->id }}" name="position_name" value="{{ $position->position_name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Position</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</x-app-layout>