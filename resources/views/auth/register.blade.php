<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .register-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .password-strength {
            height: 4px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="register-card rounded-2xl shadow-2xl p-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full shadow-lg flex items-center justify-center mb-4">
                    <i class="fas fa-user-plus text-2xl text-indigo-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Create Account
                </h2>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Enter your full name" value="{{ old('name') }}">
                        </div>
                        <div id="name-error" class="hidden text-red-500 text-xs mt-1">
                            Please enter your full name
                        </div>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
                        <div id="email-error" class="hidden text-red-500 text-xs mt-1">
                            Please enter a valid email address
                        </div>
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tel" class="block text-sm font-medium text-gray-700 mb-1">Tel Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input id="tel" name="TelNumber" type="tel" autocomplete="tel" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Enter your Tel Number (07XXXXXXXX)" value="{{ old('TelNumber') }}">
                        </div>
                        <div id="tel-error" class="hidden text-red-500 text-xs mt-1">
                            Please enter a valid Sri Lanka Tel Number (07XXXXXXXX)
                        </div>
                        @error('TelNumber')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Create a password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div class="flex space-x-1 mb-1">
                                <div id="strength-1" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                <div id="strength-2" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                <div id="strength-3" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                                <div id="strength-4" class="password-strength flex-1 bg-gray-200 rounded-full"></div>
                            </div>
                            <p id="strength-text" class="text-xs text-gray-500">Password strength</p>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                                placeholder="Confirm your password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                            </button>
                        </div>
                        <div id="confirm-error" class="hidden text-red-500 text-xs mt-1">
                            Passwords do not match
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded mt-1">
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <button type="submit" id="submitButton"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 transform hover:-translate-y-0.5 shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-indigo-300 group-hover:text-indigo-200"></i>
                    </span>
                    Create Account
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-200 ml-1">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function success() {

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: " Register Successfully  ",
                showConfirmButton: false,
                timer: 1500
            });
        }

        function error() {

            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Register Error ",
                showConfirmButton: false,
                timer: 1500
            });
        }

        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = passwordInput.parentNode.querySelector('button i');

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

         document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBars = [
                document.getElementById('strength-1'),
                document.getElementById('strength-2'),
                document.getElementById('strength-3'),
                document.getElementById('strength-4')
            ];
            const strengthText = document.getElementById('strength-text');

            let strength = 0;

            strengthBars.forEach(bar => {
                bar.style.backgroundColor = '#e5e7eb';
            });

            if (password.length > 0) {
                strength++;
                strengthBars[0].style.backgroundColor = '#ef4444';
            }

            if (password.length >= 8) {
                strength++;
                strengthBars[1].style.backgroundColor = '#f59e0b';
            }

            if (/[A-Z]/.test(password) && /[a-z]/.test(password)) {
                strength++;
                strengthBars[2].style.backgroundColor = '#10b981';
            }

            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                strength++;
                strengthBars[3].style.backgroundColor = '#10b981';
            }

            const strengthLabels = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
            const strengthColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-green-500', 'text-green-600'];

            strengthText.textContent = strengthLabels[strength];
            strengthText.className = `text-xs ${strengthColors[strength]} font-medium`;
        });

        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const confirmError = document.getElementById('confirm-error');

            if (confirmPassword && password !== confirmPassword) {
                confirmError.classList.remove('hidden');
                this.classList.add('border-red-300');
                this.classList.remove('border-gray-300');
            } else {
                confirmError.classList.add('hidden');
                this.classList.remove('border-red-300');
                this.classList.add('border-gray-300');
            }
        });

        document.getElementById('tel').addEventListener('input', function() {
            const tel = this.value.trim();
            const telError = document.getElementById('tel-error');
            const slPhoneRegex = /^07\d{8}$/;

            if (tel && !slPhoneRegex.test(tel)) {
                telError.classList.remove('hidden');
                this.classList.add('border-red-300');
                this.classList.remove('border-gray-300');
            } else {
                telError.classList.add('hidden');
                this.classList.remove('border-red-300');
                this.classList.add('border-gray-300');
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveData();
        });

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-indigo-500', 'ring-opacity-50');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-indigo-500', 'ring-opacity-50');
            });
        });

        function saveData() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const tel = document.getElementById('tel').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            const button = document.getElementById('submitButton');
            const originalText = button.innerHTML;

            let isValid = true;

            if (!name) {
                document.getElementById('name-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('name-error').classList.add('hidden');
            }

            if (!email || !/\S+@\S+\.\S+/.test(email)) {
                document.getElementById('email-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('email-error').classList.add('hidden');
            }

            const slPhoneRegex = /^07\d{8}$/;
            if (!tel || !slPhoneRegex.test(tel)) {
                document.getElementById('tel-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('tel-error').classList.add('hidden');
            }

            if (password !== confirmPassword) {
                document.getElementById('confirm-error').classList.remove('hidden');
                isValid = false;
            } else {
                document.getElementById('confirm-error').classList.add('hidden');
            }

            if (!terms) {
                alert('Please agree to the terms and conditions');
                isValid = false;
            }

            if (!isValid) return;

            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating account...';
            button.disabled = true;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: "{{ route('register') }}",
                method: 'POST',
                data: {
                    name: name,
                    email: email,
                    TelNumber: tel,
                    password: password,
                    password_confirmation: confirmPassword,
                    _token: csrfToken
                },
                success: function(response) {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    success();
                    window.location.href = '/login';
                },
                error: function(xhr) {
                    error();
                    button.innerHTML = originalText;
                    button.disabled = false;

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'Please fix the following errors:\n';

                        for (const field in errors) {
                            errorMessage += `- ${errors[field][0]}\n`;
                        }
                        alert(errorMessage);
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert('Error: ' + xhr.responseJSON.message);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>