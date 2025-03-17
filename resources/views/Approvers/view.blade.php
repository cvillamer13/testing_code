<x-app-layout>
    <x-slot name="header">
            {{ __('Approval Matrix') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-12">
                    {{-- <div class="card-header">
                        <h4 class="card-title col-6">List of Asset</h4>
                        <div class="card-title col-6 text-end">
                            <a class="btn btn-rounded btn-info" href="./add" data-target="#exampleModal">
                                Add Asset
                                <span class="btn-icon-start text-info"><i
                                        class="fa fa-plus color-info"></i>
                                </span>
                            </a>
                        </div>
                    </div> --}}

                    <div class="card py-3 px-3">
                    <div class="settings-form">
                        <div class="table-responsive">
                            <table id="example" class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th class="staff_thead_no">Type</th>
                                        <th class="staff_thead_name">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>IT Asset</td>
                                        <td><a class="badge badge-lg badge-success" data-toggle="modal" data-target="#modal_assign" id="IT_Asset" data-type_process="3" onclick="dataTypeOfprocees(3)"><i class="las la-eye"></i>view</a></td>
                                    </tr>
                                    <tr>
                                        <td>IT Gatepass</td>
                                        <td><a class="badge badge-lg badge-success" data-toggle="modal" data-target="#modal_assign" id="IT_gatepass" data-type_process="4" onclick="dataTypeOfprocees(4)"><i class="las la-eye"></i>view</a></td>
                                    </tr>

                                    <tr>
                                        <td>Fixed Asset</td>
                                        <td><a class="badge badge-lg badge-error" data-toggle="modal" data-target="#modal_assign" id="view_assign" data-asset_id="2" @disabled(true)><i class="las la-eye"></i>view</a></td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>


<div class="modal fade" id="modal_assign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary ">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    Add Approvers
                </h5>
            </div>
            <div class="modal-body">
            <form action="/Approvers/add" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="process_id" id="process_id">
                <div id="approver_container">
                    
                        <div class="row approver-row" id="data_row">
                            <div class="mb-3 col-md-3">
                                <label class="col-form-label">User<span class="text-red">*</span></label>
                                <select class="form-control" id="user_id" name="user_id[]">
                                    @foreach ($user as $us )
                                        <option value="{{ $us->id }}">{{ $us->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="mb-3 col-md-2">
                                <label class="col-form-label">Company<span class="text-red">*</span></label>
                                <select class="form-control company" name="company_id[]" onchange="getDepartment(this)">
                                    <option value="all">All</option>
                                    @foreach ($company as $com )
                                        <option value="{{ $com->id }}">{{ $com->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="mb-3 col-md-2">
                                <label class="col-form-label">Department<span class="text-red">*</span></label>
                                <select class="form-control department" name="departmen_id[]" id="departmen_id">
                                    <option value="all">All</option>
                                </select>
                            </div>
    
                            <div class="mb-3 col-md-3">
                                <label class="col-form-label">Sequence of approvals<span class="text-red">*</span></label>
                                <select class="form-control sequence" id="seq_num" name="seq_num[]">
                                    <option value="1" selected>1st Approver</option>
                                    <option value="FA">Final Approver</option>
                                </select>
                            </div>
    
                            <div class="mb-3 col-md-2">
                                <label class="col-form-label">Remove row</label>
                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                            </div>
                        </div>
                    
                </div>

                <div class="row">
                    <div class="mb-3 col-md-12">
                        
                        <button type="button" class="btn btn-outline-primary w-100" id="add_approver">Add</button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-outline-primary w-100" id="submit_approvers">Submit</button>
            </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function dataTypeOfprocees(id){
        document.getElementById("process_id").value = id;
    }
// process_id
    function ordinal_suffix_of(i) {
        let j = i % 10,
            k = i % 100;
        if (j === 1 && k !== 11) {
            return i + "st";
        }
        if (j === 2 && k !== 12) {
            return i + "nd";
        }
        if (j === 3 && k !== 13) {
            return i + "rd";
        }
        return i + "th";
    }


    function getDepartment(selectElement) {
        var companyId = $(selectElement).val();
        var departmentDropdown = $(selectElement).closest('.approver-row').find('.department');
        console.log(companyId)
        if (companyId === "all") {
            departmentDropdown.html('<option value="all">All</option>'); // Reset if "All" is selected
            return;
        }

        $.ajax({
            url: '/Location/getDepartment',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                company_id: companyId
            },
            success: function(response) {
                departmentDropdown.html('<option value="all">All</option>'); // Reset
                response.forEach(function(dept) {
                    departmentDropdown.append(`<option value="${dept.id}">${dept.name}</option>`);
                });
            },
            error: function() {
                alert("Error fetching departments!");
            }
        });
    }


    function getDepartment_edit(id, i) {
        var companyId = id
        var departmentDropdown = $('#departmen_id'+i).closest('.approver-row').find('.department');
        console.log(companyId)
        if (companyId === "all") {
            departmentDropdown.html('<option value="all">All</option>'); // Reset if "All" is selected
            return;
        }

        $.ajax({
            url: '/Location/getDepartment',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                company_id: companyId
            },
            success: function(response) {
                departmentDropdown.html('<option value="all">All</option>'); // Reset
                response.forEach(function(dept) {
                    departmentDropdown.append(`<option value="${dept.id}">${dept.name}</option>`);
                });
            },
            error: function() {
                alert("Error fetching departments!");
            }
        });
    }



    $(document).ready(function() {
    // Add new dropdown row
    $("#add_approver").click(function() {
        var newRow = $(".approver-row").first().clone(); // Clone the first row
        var rowCount = $(".approver-row").length + 1;
        
        console.log(rowCount)
        newRow.find(".sequence").html(`
            <option value="${rowCount}">${ordinal_suffix_of(rowCount)} Approver</option>
            <option value="FA">Final Approver</option>
        `);
        // newRow.find("select").val(""); // Clear selected values
        $("#approver_container").append(newRow); // Append to the container

        // var rowCount = $(".approver-row").length;
        // console.log("Total Rows: " + rowCount);
    });

    // Remove dropdown row
    $(document).on("click", ".remove-row", function() {
        if ($(".approver-row").length > 1) { // Ensure at least one row remains
            $(this).closest(".approver-row").remove();
        }
    });
});


$(document).on("click", "#IT_gatepass", function () {
        var data_process = $(this).attr("data-type_process");

        $.ajax({
            type: "POST",
            url: "/Approvers/getApprovers",
            data: {
                "_token": "{{ csrf_token() }}",
                process_id: data_process
            },
            success: function (response) {
                console.log(response)
                if(response.message.length > 0){
                    let datasrt = ``;

                    var x = 0;
                response.message.forEach((data)=>{
                    datasrt+= `<div class="row approver-row" id="data_row">`;
                        datasrt+= `<div class="mb-3 col-md-3">`;
                            datasrt+= `<label class="col-form-label">User<span class="text-red">*</span></label>`
                            datasrt+= `        <select class="form-control" id="user_id" name="user_id[]">`
                            datasrt+= `            @foreach ($user as $us )`
                            var data_id_user = '{{ $us->id }}';
                            if(data_id_user == data.user_id){
                                    datasrt+= `<option value="{{ $us->id }}" selected>{{ $us->name }}</option>`;
                            }else {
                                datasrt+= `<option value="{{ $us->id }}">{{ $us->name }}</option>`;
                            }
                        
                            datasrt+= `            @endforeach`
                            datasrt+= `        </select>`
                        datasrt+= `</div>`;
                            
                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Company<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control company" name="company_id[]" onchange="getDepartment(this)">`;
                            datasrt+= `        <option value="all">All</option>`;
                            datasrt+= `        @foreach ($company as $com )`;
                            
                            if('{{ $com->id }}' == data.company_id){
                                datasrt+= `<option value="{{ $com->id }}" selected>{{ $com->name }}</option>`;
                            }else{
                                datasrt+= `<option value="{{ $com->id }}">{{ $com->name }}</option>`;
                            }
                            datasrt+= `        @endforeach`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;
                        
                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Department<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control department" name="departmen_id[]" id="departmen_id`+x+`">`;
                            datasrt+= `        <option value="all">All</option>`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;

                        datasrt+= `<div class="mb-3 col-md-3">`;
                            datasrt+= `    <label class="col-form-label">Sequence of approvals<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control sequence" id="seq_num" name="seq_num[]">`;
                            datasrt+= `        <option value="0" selected>1st Approver</option>`;
                            datasrt+= `        <option value="FA">Final Approver</option>`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;

                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Remove row</label>`;
                            datasrt+= `    <button type="button" class="btn btn-danger remove-row">Remove</button>`;
                        datasrt+= `</div>`;
                    datasrt+= `</div>`;

                    getDepartment_edit(data.company_id,x);
                    x++;
                })
                
                document.getElementById("data_row").innerHTML =  datasrt;
            }
                }
                
        });

        // $(document).on("click", ".remove-row", function() {
        //     console.log($(".approver-row").length)
        //         if ($(".approver-row").length > 1) { // Ensure at least one row remains
        //             $(this).closest(".approver-row").remove();
        //         }
        //     });
        console.log(data_process)
    });


$(document).on("click", "#IT_Asset", function () {
        var data_process = $(this).attr("data-type_process");

        $.ajax({
            type: "POST",
            url: "/Approvers/getApprovers",
            data: {
                "_token": "{{ csrf_token() }}",
                process_id: data_process
            },
            success: function (response) {
                console.log(response)
                if(response.message.length > 0){
                    let datasrt = ``;

                    var x = 0;
                response.message.forEach((data)=>{
                    datasrt+= `<div class="row approver-row" id="data_row">`;
                        datasrt+= `<div class="mb-3 col-md-3">`;
                            datasrt+= `<label class="col-form-label">User<span class="text-red">*</span></label>`
                            datasrt+= `        <select class="form-control" id="user_id" name="user_id[]">`
                            datasrt+= `            @foreach ($user as $us )`
                            var data_id_user = '{{ $us->id }}';
                            if(data_id_user == data.user_id){
                                    datasrt+= `<option value="{{ $us->id }}" selected>{{ $us->name }}</option>`;
                            }else {
                                datasrt+= `<option value="{{ $us->id }}">{{ $us->name }}</option>`;
                            }
                        
                            datasrt+= `            @endforeach`
                            datasrt+= `        </select>`
                        datasrt+= `</div>`;
                            
                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Company<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control company" name="company_id[]" onchange="getDepartment(this)">`;
                            datasrt+= `        <option value="all">All</option>`;
                            datasrt+= `        @foreach ($company as $com )`;
                            
                            if('{{ $com->id }}' == data.company_id){
                                datasrt+= `<option value="{{ $com->id }}" selected>{{ $com->name }}</option>`;
                            }else{
                                datasrt+= `<option value="{{ $com->id }}">{{ $com->name }}</option>`;
                            }
                            datasrt+= `        @endforeach`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;
                        
                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Department<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control department" name="departmen_id[]" id="departmen_id`+x+`">`;
                            datasrt+= `        <option value="all">All</option>`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;

                        datasrt+= `<div class="mb-3 col-md-3">`;
                            datasrt+= `    <label class="col-form-label">Sequence of approvals<span class="text-red">*</span></label>`;
                            datasrt+= `    <select class="form-control sequence" id="seq_num" name="seq_num[]">`;
                            datasrt+= `        <option value="0" selected>1st Approver</option>`;
                            datasrt+= `        <option value="FA">Final Approver</option>`;
                            datasrt+= `    </select>`;
                        datasrt+= `</div>`;

                        datasrt+= `<div class="mb-3 col-md-2">`;
                            datasrt+= `    <label class="col-form-label">Remove row</label>`;
                            datasrt+= `    <button type="button" class="btn btn-danger remove-row">Remove</button>`;
                        datasrt+= `</div>`;
                    datasrt+= `</div>`;

                    getDepartment_edit(data.company_id,x);
                    x++;
                })
                
                document.getElementById("data_row").innerHTML =  datasrt;
            }
                }
                
        });

        // $(document).on("click", ".remove-row", function() {
        //     console.log($(".approver-row").length)
        //         if ($(".approver-row").length > 1) { // Ensure at least one row remains
        //             $(this).closest(".approver-row").remove();
        //         }
        //     });
        console.log(data_process)
    });
</script>
</x-app-layout>