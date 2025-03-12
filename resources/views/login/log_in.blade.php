<x-guest-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">

									<div class="text-center mb-3 text-nowrap">
										<img src="{{ asset('images/Jakalogo.png') }}" class="logo-abbr mx-2 rounded" width="76.5px" height="76.5px">
									</div>
                                    
                                    <h4 class="text-center mb-4">Sign in your account</h4>

                                    <form action="{{ route('login') }}" method="POST" id="login_form">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" id="login_email" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" class="form-control" placeholder="Password" name="password" id="login_password" required>
                                        </div>

                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ms-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1" onclick="myFunction()">
													<label class="custom-control-label" for="basic_checkbox_1">Show Password</label>
												</div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-outline-primary btn-block">Sign In</button>
                                        </div>

                                        <div class="block mt-4">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                            </label>
                                        </div>

                                    </form>
                                    
                                    

                                    <div class="new-account mt-3">
                                        <p class="">Don't have an account? <a class="text-decoration-underline" href="/sing_up_staff"> Sign up</a></p>
                                    </div>

                                    <div class="new-account mt-3">
                                        <p class=""> <a class="text-decoration-underline" href="/forgot-password"> Forgot Password</a></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function myFunction() {
            var x = document.getElementById("login_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</x-guest-layout>
