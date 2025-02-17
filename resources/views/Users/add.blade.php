<x-app-layout>
    <x-slot name="header">
            {{ __('Users') }}
    </x-slot>


        <div class="container-fluid">

            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">Add Users</h4>
                            <button type="button" class="btn btn-rounded btn-outline-info " onclick="history.back()"><i class="la la-undo"></i>Back</button>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="needs-validation" action="/User/add" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- left side -->
                                        <div class="col-xl-4">
                                            <center>
                                                <div class="form-input">
                                                    
                                                    <img id="file-preview" width="250px" height="325px" src="/images/dummy-user.png"
                                                        alt="image">
                                                    <input class="d-none" type="file" id="file-1" name="image"
                                                        onchange="showPreview(event)">

                                                </div>


                                            </center>
                                            <div class="d-flex align-items-end">
                                                <label class="btn btn-primary mt-4 w-100" id="add_product_image" for="file-1">Upload</label>
                                            </div>
                                        </div>

                                        <!-- right side -->

                                        <div class="col-xl-8">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Name<span class="text-red">*</span></label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Email<span class="text-red">*</span></label>
                                                    <input type="email" class="form-control" name="email" required>
                                                </div>
                                                
                                                
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Roles <span class="text-red">*</span></label>
                                                    <select class="form-control" name="roles" id="roles" required>
                                                        <option value selected disabled>Select One</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Status <span class="text-red">*</span></label>
                                                    <select class="form-control" name="active_status" id="active_status" required>
                                                        <option value selected disabled>Select One</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">InActive</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                        <label class="form-label">Password<span class="text-red">*</span></label>
                                                        <input type="password" class="form-control" name="pass_data" required>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Confirm password<span class="text-red">*</span></label>
                                                    <input type="password" class="form-control" name="c_password" required>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                        <label class="form-label">Company<span class="text-red">*</span></label>
                                                        <select class="form-control form-select" multiple aria-label="multiple select example" style="height: 100px; " name="company" required>
                                                            <option value="1">One</option>
                                                            <option value="2">Two</option>
                                                            <option value="3">Three</option>
                                                        </select>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Type Of Asset<span class="text-red">*</span></label>
                                                    <select class="form-select form-select-lg form-control" aria-label=".form-select-lg">
                                                        <option selected>None</option>
                                                        <option value="1">All Asset</option>
                                                        <option value="2">Fixed Asset</option>
                                                        <option value="3">IT Asset</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                            
                                        </div>
                                        
                                        
                                        <hr>
                                        <div class="text-end">
                                            <button class="btn btn-primary mt-4 w-25" type="submit">Submit</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>