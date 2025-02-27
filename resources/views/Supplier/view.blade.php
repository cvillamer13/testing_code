<x-app-layout>
    <x-slot name="header">
            {{ __('Supplier Maintenance') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">All Supplier</h4>
            <div class="card-title col-6 text-end">
                <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target="#exampleModal">
                    Add Supplier
                    <span class="btn-icon-start text-info"><i
                            class="fa fa-plus color-info"></i>
                    </span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-responsive-sm text-center">
                    <thead>
                        <tr>
                            <th class="staff_thead_name">Name</th>
                            <th class="staff_thead_name">Contact Person</th>
                            <th class="staff_thead_name">Email</th>
                            <th class="staff_thead_name">Phone</th>
                            <th class="staff_thead_name">Address</th>
                            <th class="staff_thead_name">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier as $sup)
                            <tr>
                                <td>{{ $sup->name }}</td>
                                <td>{{ $sup->contact_person }}</td>
                                <td>{{ $sup->email }}</td>
                                <td>{{ $sup->phone }}</td>
                                <td>{{ $sup->adress }}</td>
                                <td>
                                    <button type="button" class="badge badge-lg badge-info">
                                                                        
                                        <a data-toggle="modal" id="staff_id_new"
                                            data-target="#EditModal"
                                            data-name="{{ $sup->name }}"
                                            data-id="{{ $sup->id }}"><i class="la la-pencil"></i>
                                            Edit</a>

                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <h5 class="modal-title text-white" id="exampleModalLabel">
                            Add Status
                        </h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" placeholder="Status Name" name="name" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100" id="add_submit">Submit</button>
                        
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary ">
                    <h5 class="modal-title text-white" id="exampleModalLabel">
                        Edit Status
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                            </label>
                            <input type="text" class="form-control" id="name_edit" placeholder="Status Name" name="name_edit" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100" id="edit_submit">Update</button>
                    
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <button type="button" class="btn btn-danger"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>
            $(document).ready(function() {
                $('#add_submit').click(function() {
                    var name = $('#name').val();
                    var description = $('#description').val();
                    let data_loading = `<div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;
                    $('#add_submit').html(data_loading);
                    $.ajax({
                        url: '/AssetStatus/add',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: name,
                        },
                        success: function(data) {
                            toastr.success(data.message);
    
                            location.reload();
    
                        },
                        error: function(data) {
                            toastr.error(data.responseJSON.message);
                            $('#add_submit').html('Submit');
                        }
                    });
                });
            });
    
    
    $(document).on("click", "#staff_id_new", function () {
        var name = $(this).attr("data-name");
        var id = $(this).attr("data-id");
        console.log(name, id);
        $('#name_edit').val(name);

            $('#edit_submit').click(function() {
                var name = $('#name_edit').val();
                let data_loading = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`;
                $('#edit_submit').html(data_loading);
                $.ajax({
                    url: '/AssetStatus/edit/' + id,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                    },
                    success: function(data) {
                        toastr.success(data.message);
                        location.reload();
                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                        $('#edit_submit').html('Update');
                    }
                });
            });
    });
    
    
        </script>
</x-app-layout>