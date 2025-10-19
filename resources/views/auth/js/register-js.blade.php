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