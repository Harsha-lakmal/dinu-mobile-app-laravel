<script>
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('mobileSidebarOverlay').classList.remove('hidden');
        });

        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobileSidebarOverlay').classList.add('hidden');
        });

        document.getElementById('mobileSidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            this.classList.add('hidden');
        });

        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (!currentPassword || !newPassword || !confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill in all password fields.'
                });
                return;
            }
            
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'New password and confirmation do not match.'
                });
                return;
            }
            
            if (newPassword.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'New password must be at least 8 characters long.'
                });
                return;
            }
            
            const formData = {
                current_password: currentPassword,
                new_password: newPassword,
            };
            
      
           
            changePassword(formData);
        });

        document.getElementById('enable2faBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Enable Two-Factor Authentication',
                text: 'Are you sure you want to enable two-factor authentication?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, enable it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Two-factor authentication has been enabled.'
                    });
                    
                    const button = document.getElementById('enable2faBtn');
                    button.textContent = 'Disable';
                    button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                    
                    button.removeEventListener('click', arguments.callee);
                    button.addEventListener('click', function() {
                        Swal.fire({
                            title: 'Disable Two-Factor Authentication',
                            text: 'Are you sure you want to disable two-factor authentication?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#d1d5db',
                            confirmButtonText: 'Yes, disable it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Two-factor authentication has been disabled.'
                                });
                                
                                button.textContent = 'Enable';
                                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                                button.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                                
                                button.removeEventListener('click', arguments.callee);
                                button.addEventListener('click', arguments.callee.caller);
                            }
                        });
                    });
                }
            });
        });

        document.getElementById('deleteAccountBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#d1d5db',
                confirmButtonText: 'Yes, delete it!',
                input: 'password',
                inputPlaceholder: 'Enter your password to confirm',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off'
                },
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Please enter your password');
                    }
                    return password;
                }
            }).then((result) => {
                console.log(result);
                
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete.account') }}",
                        type: 'DELETE',
                        data: JSON.stringify({ password: result.value }),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Your account has been deleted.',
                                    confirmButtonColor: '#4f46e5'
                                }).then(() => {
                                    window.location.href = "{{ route('login') }}";
                                });
                            } else {
                                
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Failed to delete account.'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the account.'
                            });
                        }
                    });
                }
            });
        });

        function changePassword(formData) {
                 console.log(formData);
            $.ajax({
                url: "{{ route('change.password') }}",
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password changed successfully!'
                        }).then(() => {
                            document.getElementById('passwordForm').reset();
                        });
                    } else {
                    console.log(Response);
                    
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to change password.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while changing the password.'
                    });
                }
            });
        }
          function logOut() {
        $.ajax({
            url: "{{ route('logout') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = response.redirect_url;
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Logout Failed",
                    text: "Something went wrong!"
                });
            }
        });
    }
     document.addEventListener('DOMContentLoaded', function() {
   
      const user = JSON.parse(localStorage.getItem('userData'));
        if (user && user.name) {
            document.getElementById('userName').textContent = user.name;
        }

    });      
    </script>