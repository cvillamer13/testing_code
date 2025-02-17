<x-app-layout>
    <x-slot name="header">
            {{ __('Profile') }}
    </x-slot>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="text-center py-3">
                            <div>
                                
                                <span>
                                    <img src="{{ asset('storage/'. $user->image_path) }}" class="rounded-circle" width="75" height="75" alt="image">
                                </span>
                                
                            </div>
                            
                        </div>
                        <ul class="list-group">
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center">
                                Full Name  :<span class="fw-bold">
                                    {{ $user->name }}
                                </span>
                            </li>


                            <li
                                class="list-group-item d-flex justify-content-between align-items-center">
                                Email :<span class="fw-bold">
                                    {{ $user->email }}
                                </span>
                            </li>

                            <li
                                class="list-group-item d-flex justify-content-between align-items-center">
                                Roles :<span class="fw-bold">
                                    {{ session('user_role') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-8">
                     <div class="card py-3 px-3">
                    <div class="settings-form">
                        <h4 class="text-primary mb-4">Account Settings </h4>
                        <form action="/profile/view" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" placeholder="First Name" class="form-control"
                                        name="firstname" value="{{ $user->name }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email </label>
                                    <input type="email" placeholder="email" class="form-control"
                                        name="email" value="{{ $user->email }}" disabled readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Choose a photo </label>
                                    <input type="file" placeholder="photo" class="form-control"
                                        name="image_path">
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit">Submit </button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    
</x-app-layout>