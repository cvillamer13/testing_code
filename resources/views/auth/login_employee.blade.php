<x-employee-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 mt-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/Jakalogo.png') }}" alt="Company Logo" class="mb-4" style="height: 50px;">
                            <h3 class="fw-bold">Employee Portal</h3>
                            <p class="text-muted">Enter your credentials to access your account</p>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login_employee') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                    name="email" 
                                    id="email" 
                                    class="form-control py-2 @error('email') is-invalid @enderror" 
                                    placeholder="employee@company.com" 
                                    required 
                                    autofocus
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                        name="password" 
                                        id="password" 
                                        class="form-control py-2 @error('password') is-invalid @enderror" 
                                        placeholder="••••••••" 
                                        required>
                                    <button class="btn btn-outline-primary toggle-password" onclick="togglePassword(this)" type="button">
                                        <i class="las la-eye-slash"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                Login
                            </button>

                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('scripts') --}}
    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            if (icon.classList.contains('la-eye')) {
                icon.classList.replace('la-eye', 'la-eye-slash');
            } else {
                icon.classList.replace('la-eye-slash', 'la-eye');
            }
        }

    </script>
    {{-- @endpush --}}
</x-employee-layout>