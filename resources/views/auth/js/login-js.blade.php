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
                    getUserData(email);


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

        function getUserData(email) {
            $.ajax({
                url: "{{route('user.data')}}",
                method: 'GET',
                accepts: 'application/json',
                data: {
                    email: email
                },
                success: function(response) {
                    console.log("data: ", response);

                    localStorage.setItem('userData', JSON.stringify(response));
                    console.log("User data saved in localStorage!");
                },
                error: function(xhr) {
                    console.log(xhr);
                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            errorMessage = errors.email[0];
                        }
                    } else if (xhr.status === 404) {
                        errorMessage = 'User not found with this email.';
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                }
            });
        }


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
