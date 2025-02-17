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
                            <h4 class="card-title ">Edit Users for {{ $user->name }}</h4>
                            <button type="button" class="btn btn-rounded btn-outline-info " onclick="history.back()"><i class="la la-undo"></i>Back</button>
                        </div>
                        <div class="card-body">
                            <div class="form-validation">
                                <form class="needs-validation" action="/User/edit/{{ $user->id }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- left side -->
                                        <div class="col-xl-4">
                                            <center>
                                                <div class="form-input">
                                                    
                                                    <img id="file-preview" width="250px" height="250px" src="{{ asset('storage/'.$user->image_path) }}"
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
                                                    <input type="text" class="form-control" name="name_edit" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Email<span class="text-red">*</span></label>
                                                    <input type="email" class="form-control" name="email_edit" value="{{ $user->email }}"  required>
                                                </div>
                                                
                                                
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Roles <span class="text-red">*</span></label>
                                                    <select class="form-control" name="roles" id="roles" required>
                                                        <option value selected disabled>Select One</option>
                                                        @foreach ($roles as $role)
                                                            @if ($role->id == $user->roles_id)
                                                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                                
                                                            @else
                                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Status <span class="text-red">*</span></label>
                                                    <select class="form-control" name="active_status" id="active_status" required>
                                                        <option value selected disabled>Select One</option>
                                                        @if ($user->active_status == 1)
                                                            <option value="1" selected>Active</option>
                                                            <option value="0">InActive</option>
                                                        @elseif ($user->active_status == 0)
                                                            <option value="1">Active</option>
                                                            <option value="0" selected>InActive</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                        <label class="form-label">Password<span class="text-red">*</span></label>
                                                        <input type="password" class="form-control" name="pass_data">
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Confirm password<span class="text-red">*</span></label>
                                                    <input type="password" class="form-control" name="c_password">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                        <label class="form-label">Company<span class="text-red">*</span></label>
                                                        <select class="form-control form-select" multiple aria-label="multiple select example" style="height: 100px; " name="company[]" required>
                                                            @php
                                                                $arrCompany = explode('~', $user->company);
                                                                // print_r($arrCompany);
                                                                // exit;
                                                            @endphp
                                                            
                                                            @foreach ($company as $comp)
                                                                <option value="{{ $comp->id }}" {{ in_array($comp->id, $arrCompany) ? 'selected' : '' }}>
                                                                    {{ $comp->name }}
                                                                </option>
                                                            @endforeach

                                                            {{-- @foreach ($company as $comp)
                                                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                                            @endforeach --}}
                                                        </select>
                                                </div>

                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Type Of Asset<span class="text-red">*</span></label>
                                                    <select class="form-select form-select-lg form-control" aria-label=".form-select-lg" name="type_of_asset" required>
                                                        <option selected>None</option>
                                                        <option value="1" {{ $user->type_asset == 1 ? 'selected' : '' }}>All Asset</option>
                                                        <option value="2" {{ $user->type_asset == 2 ? 'selected' : '' }}>Fixed Asset</option>
                                                        <option value="3" {{ $user->type_asset == 3 ? 'selected' : '' }}>IT Asset</option>
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