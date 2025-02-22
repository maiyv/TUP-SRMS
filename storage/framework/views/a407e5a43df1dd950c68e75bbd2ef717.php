<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/user-management.css')); ?>" rel="stylesheet">
    <title>Admin - User Management</title>
</head>
<body>
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="user-content">
        <div class="user-header">
            <h1>User Management</h1>
        </div>
        
        <div class="top-controls">
            <!-- Add User Button -->
            <button class="btn btn-primary add-user-btn" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>
        
        <div class="dropdown-container">
            <!-- Role Filter -->
            <select name="user_role" id="role">
                <option value="all">All Users</option>
                <option value="student">Student</option>
                <option value="faculty">Faculty & Staff</option>
            </select>

            <!-- Status Filter -->
            <select name="status" id="status">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="pending_verification">Pending Verification</option>
                <option value="verified">Verified</option>
            </select>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-input-wrapper">
                    <input type="text" id="user-search" name="user-search" placeholder="Search users...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions">
              <!--  <button class="btn-export" id="export-csv">
                    <i class="fas fa-file-export"></i> Export CSV
                </button> -->
                <button class="btn-delete" id="bulk-delete">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        </div>

        <div class="user-table-container">
            <h4>Users List</h4>
            <div id="users-table-wrapper">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>ID</th>
                            <th>User Data</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Account Created</th>
                            <th>Verification Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><input type="checkbox" class="user-select" value="<?php echo e($user->id); ?>"></td>
                            <td><?php echo e($user->id); ?></td>
                            <td>
                            <strong>Name: </strong><?php echo e($user->name); ?><br>
                            <strong>Username: </strong><?php echo e($user->username); ?><br>
                            <strong>Email: </strong><?php echo e(isset($user->email) ? $user->email : $user->username); ?> <br>
                            <?php if($user->role === 'Student'): ?>
                                <strong>Student ID: </strong><?php echo e($user->student_id ?? 'Not Assigned'); ?>

                            <?php endif; ?>

                            </td>
                            <td><?php echo e(ucfirst($user->role)); ?></td>
                            <td>
                                <span class="status-badge <?php echo e($user->status ?? 'active'); ?>">
                                    <?php echo e($user->status ?? 'Active'); ?>

                                </span>
                            </td>
                            <td>
                                <strong>Date: </strong><?php echo e($user->created_at->format('Y-m-d')); ?><br>
                                <strong>Time: </strong><?php echo e($user->created_at->format('h:i A')); ?>

                            </td>

                            <td>
                                <?php if($user->role === 'Student'): ?>
                                    <?php if(!$user->email_verified_at): ?>
                                        <span class="status-badge pending">Email Unverified</span>
                                    <?php elseif(!$user->student_id): ?>
                                        <span class="status-badge pending">Details Required</span>
                                    <?php elseif(!$user->admin_verified): ?>
                                        <span class="status-badge pending">Pending Verification</span>
                                        <button class="btn-verify" title="Verify Student" data-id="<?php echo e($user->id); ?>">Verify</button>
                                    <?php else: ?>
                                        <span class="status-badge verified">Verified</span>
                                    <?php endif; ?>
                                <?php elseif($user->role === 'Faculty & Staff'): ?>
                                    <?php if(!$user->email_verified_at): ?>
                                        <span class="status-badge pending">Email Unverified</span>
                                    <?php elseif(!$user->admin_verified): ?>
                                        <span class="status-badge pending">Pending Verification</span>
                                        <button class="btn-verify-faculty" title="Verify Faculty/Staff" data-id="<?php echo e($user->id); ?>">Verify</button>
                                    <?php else: ?>
                                        <span class="status-badge verified">Verified</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="status-badge">N/A</span>
                                <?php endif; ?>
                            </td>

                            <td class="b">
                                <button class="btn-edit" title="Edit" data-id="<?php echo e($user->id); ?>">Edit</button>
                                <button class="btn-status" title="Toggle Status" data-id="<?php echo e($user->id); ?>">Status</button>
                                <button class="btn-reset" title="Reset Password" data-id="<?php echo e($user->id); ?>">Reset</button>
                                <button class="btn-delete" title="Delete" data-id="<?php echo e($user->id); ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include the modal from the admin > modal -->
    <?php echo $__env->make('admin.modal.usermanagement-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.modal.verify-student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.modal.verify-facultystaff', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>
    <script src="<?php echo e(asset('js/user-management.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/admin/user-management.blade.php ENDPATH**/ ?>