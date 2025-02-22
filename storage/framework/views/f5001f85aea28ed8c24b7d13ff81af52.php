<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="<?php echo e(asset('css/admin_myprofile.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">

    <title>My Profile</title>
</head>
<body>

    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="profile-container">
        <div class="back-button-container">
            <a href="<?php echo e(url('/admin_dashboard')); ?>" class="btn btn-secondary back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h2>My Profile</h2>
        <p>Manage and protect your account</p>

       <!-- Display Profile Image -->
        <div class="profile-header">
            <div class="profile-image">
                <?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::guard('admin')->user()->profile_image)); ?>" alt="Profile Image" class="profile-img">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Default Profile Image" class="profile-img">
                <?php endif; ?>
            </div>
            <?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()): ?>
            <h3 class="username"><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                </div>

                <div class="user-info">

            <p>
                <span class="label">Name:</span>
                <span class="user-data"><?php echo e(Auth::guard('admin')->user()->name); ?></span>
            </p>
            <p>  
                <span class="label">Username:</span>
                <span class="user-data">
                    <span id="username-display"><?php echo e(Auth::guard('admin')->user()->username); ?></span>
                    <input type="text" id="username-input" value="<?php echo e(Auth::guard('admin')->user()->username); ?>" style="display:none;">
                    <span id="edit-username" style="color: blue; cursor: pointer; text-decoration: underline; margin-left: 10px;">Edit</span>
                    <span class="save-username-btn" id="save-username-btn" style="display:none; cursor: pointer; color: green; text-decoration: underline; margin-left: 10px;">Save</span>
                </span>
            </p>

            <p>
                <span class="label">Role:</span>
                <span class="user-data"><?php echo e(Auth::guard('admin')->user()->role); ?></span>
            </p>
            <?php else: ?>
                <p>User not logged in.</p>
            <?php endif; ?>
        </div>

                    
        <!-- Form for uploading profile image -->
        <form action="<?php echo e(route('admin.profile.upload')); ?>" method="POST" enctype="multipart/form-data" class="profile-upload-form">
            <?php echo csrf_field(); ?>
            <label for="profile_image">Upload Profile</label>
            <input type="file" name="profile_image" id="profile_image">
           
            <div class="button-container">
                <button type="submit" class="upload-btn">Upload</button>
            </div>       
        </form>

        <!-- Form for removing profile image -->
        <form action="<?php echo e(route('admin.profile.remove')); ?>" method="POST" class="remove-image-form">
            <?php echo csrf_field(); ?>
            <div class="button-container">
                <button type="submit" class="remove-image-btn">Remove Image</button>
            </div>
        </form>
        
        <h2 class="changepass-header">Set or Change Password</h2>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger" style="list-style-type: none; padding-left: 0;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
            <form action="<?php echo e(route('myprofile.setPassword')); ?>" method="POST" class="password-form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="password"  class="label">New Password</label>
                    <input type="password" name="password" id="password"  class="input-field" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" placeholder="Enter Confirm Password" required>
                </div>
                <button type="submit" class="btn">Set Password</button>
            </form>
    </div>

    <?php echo $__env->make('admin.modal.myprofile-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
          document.getElementById('edit-username').addEventListener('click', function() {
            // Hide the username display and the edit link
            document.getElementById('username-display').style.display = 'none';
            this.style.display = 'none';

            // Show the input field and save link
            document.getElementById('username-input').style.display = 'inline';
            document.getElementById('save-username-btn').style.display = 'inline';
        });

        document.getElementById('save-username-btn').addEventListener('click', function() {
            const newUsername = document.getElementById('username-input').value;

            // AJAX request to save the new username
            fetch('/update-username', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                },
                body: JSON.stringify({ username: newUsername }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the displayed username and hide input
                    document.getElementById('username-display').textContent = newUsername;
                    document.getElementById('username-display').style.display = 'inline';
                    document.getElementById('edit-username').style.display = 'inline';
                    document.getElementById('username-input').style.display = 'none';
                    document.getElementById('save-username-btn').style.display = 'none';

                    // Show success modal
                    $('#usernameUpdateSuccessModal').modal('show');
                } else {
                    alert('Error updating username.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });


    document.addEventListener('DOMContentLoaded', function() {
        // Check if success messages are present
        if ('<?php echo e(session('upload_success')); ?>') {
            $('#profileImageUploadSuccessModal').modal('show');
        }

        if ('<?php echo e(session('image_removed')); ?>') {
            $('#profileImageRemoveSuccessModal').modal('show');
        }
    });

    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SRMS\resources\views/admin/admin_myprofile.blade.php ENDPATH**/ ?>