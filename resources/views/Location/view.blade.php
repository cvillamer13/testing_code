<style>
    .select2-container{
        z-index:100000;
    }
    
</style>
<x-app-layout>
    <x-slot name="header">
            {{ __('Location') }}
    </x-slot>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title col-6">All Location</h4>
            <div class="card-title col-6 text-end">
                <button type="button" class="btn btn-rounded btn-info" data-toggle="modal" data-target="#exampleModal">
                    Add Location
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
                            <th class="staff_thead_name">Company</th>
                            <th class="staff_thead_name">Department</th>
                            <th class="staff_thead_name">Action</th>
                            <th class="staff_thead_name">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($location as $loc)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $loc->location_data->name ?? "" }}</td>
                                <td>{{ $loc->company->name}}</td>
                                <td>{{ $loc->department->name }}</td>
                                <td>
                                    {{-- <a class="badge badge-lg badge-info" id="staff_id_new" href="/Company/edit/{{ $comp->id }}"><i class="la la-pencil"></i>Edit</a> --}}
                                    <button type="button" class="badge badge-lg badge-info">
                                                                        
                                        <a data-toggle="modal" id="staff_id_new"
                                            data-target="#EditModal"
                                            data-name="{{ $loc->location_id }}"
                                            data-company_id="{{ $loc->comp_id }}"
                                            data-dept_id="{{ $loc->department_id }}"
                                            data-id="{{ $loc->id }}"><i class="la la-pencil"></i>
                                            Edit</a>

                                    </button>

                                    
                                </td>
                                <td>
                                    <button type="button" class="badge badge-lg badge-danger">
                                                                        
                                        <a  onclick="onDelete({{ $loc->id }})"><i class="fas fa-trash"></i>Delete</a>
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


@csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary ">
                        <h5 class="modal-title text-white" id="exampleModalLabel">
                            Add Location
                        </h5>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-9">
                                <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                                </label>
                                <input type="text" class="form-control" id="name" placeholder="Location Name" name="name" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_exist" class="col-form-label">is Exist</label>
                                <input type="checkbox" class="form-check" id="is_exist" name="is_exist" onclick="getLocation()">
                                <input type="hidden" class="form-control" id="is_exist_val" name="is_exist_val" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Company<span class="text-red">*</span></label>
                                 

                                    <select id="company_id" class="form-control select2-container" style="width:100%;" required="" data-val="true" name="company_id" onchange="getDepartment(0)">
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($company as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Department<span class="text-red">*</span>
                                    </label>
                                    <select class="form-control" id="dep_id_edit" name="dep_id_edit" required>
                                        <option value="" disabled selected>Select Department</option>
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
                            Edit Location
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-9">
                                <label for="recipient-name" class="col-form-label">Name<span class="text-red">*</span>
                                </label>
                                <input type="text" class="form-control" id="name_edit" placeholder="Role Name" name="name_edit" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="is_exist" class="col-form-label">is Exist</label>
                                <input type="checkbox" class="form-check" id="is_exist_edit" name="is_exist_edit" onclick="getLocation_edit()">
                                <input type="hidden" class="form-control" id="is_exist_val_edit" name="is_exist_val_edit" value="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Company<span class="text-red">*</span>
                                    </label>
                                    <select class="form-control" id="company_id_edit" name="company_id_edit" onchange="getDepartment()" required>
                                        <option value="" disabled selected>Select Company</option>
                                        @foreach ($company as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Department<span class="text-red">*</span>
                                    </label>
                                    <select class="form-control" id="dep_edit" name="dep_edit" required>
                                        <option value="" disabled selected>Select Department</option>
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
            var dep_id_edit = $('#dep_id_edit').val();
            var is_exist_val = $('#is_exist_val').val();

            let data_loading = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`;
            $('#add_submit').html(data_loading);
            $.ajax({
                url: '/Location/add',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: name,
                    description: description,
                    company_id: company_id,
                    dep_id_edit: dep_id_edit,
                    is_exist_val: is_exist_val
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
        var company_id = $(this).attr("data-company_id");
        var dep_id = $(this).attr("data-dept_id");
        var id = $(this).attr("data-id");

        document.getElementById("is_exist_edit").checked = true;
        getLocation_edit(name );
        // $('#name_edit').val(name);
        $("#company_id_edit").val(company_id).attr("selected", "selected");
        getDepartment(dep_id);
        // setTimeout(function() {
        //     $("#dep_edit").val(dep_id).attr("selected", "selected");
        // }, 2000); // 10 seconds (10,000 milliseconds)
            $('#edit_submit').click(function() {


                var name = $('#name_edit').val();
                var company_id = $('#company_id_edit').val();
                var dep_id_edit = $('#dep_edit').val();


                let data_loading = `<div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>`;
                $('#edit_submit').html(data_loading);

                var is_exist_val_edit = $('#is_exist_val_edit').val();
                $.ajax({
                    url: '/Location/edit/' + id,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                        // description: description,
                        company_id: company_id,
                        dep_id_edit: dep_id_edit,
                        is_exist_val_edit : is_exist_val_edit
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
    
    function getDepartment(id){
        
        if(id == 0){
            var company_id = $('#company_id').val();
            $.ajax({
                url: '/Location/getDepartment',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id
                },
                success: function(data) {
                    let data_str = `<option value="" disabled selected>Select Department</option>`;

                    data.forEach(element => {
                        data_str += `<option value="${element.id}">${element.name}</option>`;
                    });
                
                    $('#dep_id_edit').html(data_str);
                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                }
            });
        }else{
            var company_id = $('#company_id_edit').val();
            $.ajax({
                url: '/Location/getDepartment',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    company_id: company_id
                },
                success: function(data) {
                    let data_str = `<option value="" disabled selected>Select Department</option>`;

                    data.forEach(element => {
                        console.log(id, element.id);
                        if (id == element.id) {
                            data_str += `<option value="${element.id}" selected>${element.name}</option>`;
                            
                        }else{
                            data_str += `<option value="${element.id}">${element.name}</option>`;
                        }
                        // data_str += `<option value="${element.id}">${element.name}</option>`;
                    });
                
                    $('#dep_edit').html(data_str);
                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                }
            });
        }
        
    }


    function getLocation(){
        var is_exist = $('#is_exist').is(':checked');
        if(is_exist){
            $('#is_exist_val').val(1);
            
            // $('#name').select2({
            //     placeholder: "Select Location",
            //     allowClear: false,
            //     ajax: {
            //         url: '/Location/getLocation_name',
            //         type: 'POST',
            //         dataType: 'json',
            //         delay: 250,
            //         headers: {
            //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for POST
            //         },
            //         data: function(params) {
            //             return {
            //                 search: params.term || '' // send search term as 'search'
            //             };
            //         },
            //         processResults: function(data) {
            //             // assuming data is an array of { id: 1, name: "Location Name" }
            //             return {
            //                 results: data.map(function(item) {
            //                     return {
            //                         id: item.id,
            //                         text: item.name
            //                     };
            //                 })
            //             };
            //         },
            //         cache: true
            //     },
            //     minimumResultsForSearch: Infinity // disable search box if you want
            // });

            $.ajax({
                url: '/Location/getLocation_name',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    let options = `<option></option>`;
                    data.forEach(function(item) {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });

                    $('#name').html('');
                    $('#name').replaceWith('<select id="name" class="form-control select2-container" style="width:100%;" name="name" required> ' + options + ' </select>');
                    // $('#name').html(options);
                    $('#name').select2({
                        placeholder: "Select Location",
                        allowClear: false
                    });

                    
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });



            
        }else{
            $('#is_exist_val').val(0);
            $('#name').html('');
            $('#name').replaceWith('<input type="text" class="form-control" id="name" placeholder="Location Name" name="name" required>');
            $('#name').select2('destroy'); // Destroy the select2 instance if it exists
        }
       
    }


    function getLocation_edit(name){
        var is_exist = $('#is_exist_edit').is(':checked');
        if(is_exist){
            $('#is_exist_val_edit').val(1);
            
            // alert(name);
            $.ajax({
                url: '/Location/getLocation_name',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    let options = `<option selected disabled>please select</option>`;
                    data.forEach(function(item) {
                        if(item.id == name){
                            options += `<option value="${item.id}" selected>${item.name}</option>`;
                        }else{
                            options += `<option value="${item.id}">${item.name}</option>`;
                        }
                        // options += `<option value="${item.id}">${item.name}</option>`;
                    });

                    $('#name_edit').html('');
                    $('#name_edit').replaceWith('<select id="name_edit" class="form-control select2-container" style="width:100%;" name="name_edit" required> ' + options + ' </select>');
                },
                error: function(error) {
                    toastr.error(error.responseJSON.message);
                }
            });



            
        }else{
            $('#is_exist_val_edit').val(0);
            $('#name_edit').html('');
            $('#name_edit').replaceWith('<input type="text" class="form-control" id="name_edit" placeholder="Location Name" name="name_edit" required>');
            $('#name_edit').select2('destroy'); // Destroy the select2 instance if it exists
        }
       
    }



    function onDelete(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                url: '/Location/delete',
                type: 'POST',
                data: {
                "_token": "{{ csrf_token() }}",
                'id': id
                },
                success: function(data) {
                    console.log(data);
                Swal.fire(
                    'Deleted!',
                    data.message,
                    'success'
                ).then(() => {
                    location.reload();
                });
                },
                error: function(data) {
                Swal.fire(
                    'Error!',
                    data.responseJSON.message,
                    'error'
                );
                }
            });
            }
        });
    }
</script>
</x-app-layout>