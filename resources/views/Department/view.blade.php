<x-app-layout>
    <x-slot name="header">
            {{ __('Department') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">All Department</h4>
            <div class="card-title col-6 text-end">
                <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target="#exampleModal">
                    Add Department
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
                            <th class="staff_thead_no">No</th>
                            <th class="staff_thead_name">Name</th>
                            <th class="staff_thead_name">Description</th>
                            <th class="staff_thead_name">Company</th>
                            <th class="staff_thead_name">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($department as $dep)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $dep->name }}</td>
                                <td>{{ $dep->description }}</td>
                                <td>{{ $dep->company->name  }}</td>
                                <td>
                                    {{-- <a class="badge badge-lg badge-info" id="staff_id_new" href="/Company/edit/{{ $comp->id }}"><i class="la la-pencil"></i>Edit</a> --}}
                                    <button type="button" class="badge badge-lg badge-info">
                                                                        
                                        <a data-toggle="modal" id="staff_id_new"
                                            data-target="#EditModal"
                                            data-name="{{ $dep->name }}"
                                            data-description="{{ $dep->description }}"
                                            data-company_id="{{ $dep->company_id }}"
                                            data-id="{{ $dep->id }}"><i class="la la-pencil"></i>
                                            Edit</a>

                                    </button>
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

@csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <h5 class="modal-title text-white" id="exampleModalLabel">
                            Add Department
                        </h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" placeholder="Department Name" name="name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Description<span class="text-red">*</span>
                                    </label>
                                    <textarea type="text" class="form-control" id="description" placeholder="Description" name="description" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Company<span class="text-red">*</span>
                                    </label>
                                    <select class="form-control" id="company_id" name="company_id" required>
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($company as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>
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
                        Edit Department
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                            </label>
                            <input type="text" class="form-control" id="name_edit" placeholder="Role Name" name="name_edit" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Description<span class="text-red">*</span>
                                </label>
                                <textarea type="text" class="form-control" id="description_edit" placeholder="Description" name="description_edit" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Company<span class="text-red">*</span>
                                </label>
                                <select class="form-control" id="company_id_edit" name="company_id_edit" required>
                                    <option value="" disabled selected>Select Company</option>
                                    @foreach ($company as $comp)
                                        <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                        
                                    @endforeach
                                </select>
                            </div>
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
            var company_id = $('#company_id').val();
            let data_loading = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`;
            $('#add_submit').html(data_loading);
            $.ajax({
                url: '/Department/add',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: name,
                    description: description,
                    company_id: company_id
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
        var description = $(this).attr("data-description");
        var company_id = $(this).attr("data-company_id");
        var id = $(this).attr("data-id");
        console.log(name, description, id);
        $('#name_edit').val(name);
        $('#description_edit').val(description);
        $("#company_id_edit").val(company_id).attr("selected", "selected");
            $('#edit_submit').click(function() {


                var name = $('#name_edit').val();
                var description = $('#description_edit').val();
                var company_id = $('#company_id_edit').val();


                let data_loading = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`;
                $('#edit_submit').html(data_loading);
                $.ajax({
                    url: '/Department/edit/' + id,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                        description: description,
                        company_id: company_id
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