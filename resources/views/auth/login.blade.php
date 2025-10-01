<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Login Card -->
        <div class="login-card rounded-2xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full shadow-lg flex items-center justify-center mb-4">
                    <i class="fas fa-lock text-2xl text-indigo-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Sign in to your account to continue
                </p>
            </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="space-y-4">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Enter your email" value="{{ old('email') }}">
                        </div>
                        <div id="email-error" class="error-message">
                            Please enter a valid email address
                        </div>
                        @error('email')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500 transition duration-200">
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Enter your password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        <div id="password-error" class="error-message">
                            Please enter your password
                        </div>
                        @error('password')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitButton"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-indigo-300 group-hover:text-indigo-200"></i>
                    </span>
                    Sign in to your account
                </button>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-200 ml-1">
                            Sign up now
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('#password + button i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');

            // Reset errors
            emailError.style.display = 'none';
            passwordError.style.display = 'none';

            // Email validation
            if (!email) {
                emailError.textContent = 'Please enter your email address';
                emailError.style.display = 'block';
                isValid = false;
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.style.display = 'block';
                isValid = false;
            }

            // Password validation
            if (!password) {
                passwordError.textContent = 'Please enter your password';
                passwordError.style.display = 'block';
                isValid = false;
            }

            return isValid;
        }

        // Form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;
            const button = document.getElementById('submitButton');
            const originalText = button.innerHTML;

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in...';
            button.disabled = true;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // AJAX request
            $.ajax({
                url: "{{ route('login') }}",
                method: 'POST',
                data: {
                    email: email,
                    password: password,
                    remember: remember,
                    _token: csrfToken
                },
                success: function(response) {
                    // Reset button
                    button.innerHTML = originalText;
                    button.disabled = false;
                    console.log(response);
                    

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Login successful! Redirecting...',
                        timer: 1500,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.href = response.redirect || '/dashboard';
                        }
                    });
                },
                error: function(xhr) {
                    // Reset button
                    console.log(xhr);
                    
                    button.innerHTML = originalText;
                    button.disabled = false;

                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            errorMessage = errors.email[0];
                        } else if (errors.password) {
                            errorMessage = errors.password[0];
                        }
                    } else if (xhr.status === 401) {
                        // Unauthorized
                        errorMessage = 'Invalid email or password. Please try again.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: errorMessage,
                        confirmButtonColor: '#4f46e5'
                    });
                }
            });
        });

        // Real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value.trim();
            const emailError = document.getElementById('email-error');

            if (!email) {
                emailError.textContent = 'Please enter your email address';
                emailError.style.display = 'block';
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });

        document.getElementById('password').addEventListener('blur', function() {
            const password = this.value;
            const passwordError = document.getElementById('password-error');

            if (!password) {
                passwordError.textContent = 'Please enter your password';
                passwordError.style.display = 'block';
            } else {
                passwordError.style.display = 'none';
            }
        });

        // Add input focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-indigo-500', 'ring-opacity-50');
                // Hide error when user starts typing
                const errorId = this.id + '-error';
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-indigo-500', 'ring-opacity-50');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>