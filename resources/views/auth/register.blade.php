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

        .hidden { display: none; }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="register-card rounded-2xl shadow-2xl p-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-white rounded-full shadow-lg flex items-center justify-center mb-4">
                    <i class="fas fa-user-plus text-2xl text-indigo-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Create Account</h2>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <div class="space-y-4">
                    <!-- Full Name -->
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
                        <div id="name-error" class="hidden text-red-500 text-xs mt-1">Please enter your full name</div>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
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
                        <div id="email-error" class="hidden text-red-500 text-xs mt-1">Please enter a valid email address</div>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Tel Number -->
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
                        <div id="tel-error" class="hidden text-red-500 text-xs mt-1">Please enter a valid Sri Lanka Tel Number (07XXXXXXXX)</div>
                        @error('TelNumber')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
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
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Confirm Password -->
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
                        <div id="confirm-error" class="hidden text-red-500 text-xs mt-1">Passwords do not match</div>
                    </div>

                    <!-- Terms -->
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
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-200 ml-1">Sign in here</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    @yield('scripts')
</body> 
 @include('auth.js.register-js')

</html>
  