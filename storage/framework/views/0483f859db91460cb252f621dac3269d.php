<!-- resources/views/layouts/admin-navbar.blade.php -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

<!-- NAVBAR -->
<nav class="navbar">    
    <div class="logo_item">
        <i class="bx bx-menu" id="sidebarOpen"></i>
        <a href="<?php echo e(url('/admin_dashboard')); ?>">
            <img src="<?php echo e(asset('images/tuplogo.png')); ?>" alt="Logo" class="logo">
        </a>      
        <span class="navbar-title">TUP SRMS</span>    
    </div>
    
    <div class="navbar-content">
        <a href="<?php echo e(url('/notifications')); ?>" class="notification-icon"><i class="bx bx-bell"></i></a>
        <li class="dropdown">
            <a href="#" class="profile-icon">
                <?php if(Auth::check() && Auth::user()->profile_image): ?>
                    <img src="<?php echo e(asset('storage/' . Auth::user()->profile_image)); ?>" alt="Profile Image" class="profile-img-navbar">
                <?php elseif(Auth::check()): ?>
                    <img src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Default Profile Image" class="profile-img-navbar">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Default Profile Image" class="profile-img-navbar">
                <?php endif; ?>
            </a>
            <?php if(Auth::check()): ?>
                <div class="dropdown-content">
                    <a href="<?php echo e(route('admin.admin_myprofile')); ?>">My Profile</a>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">Logout</a>
                    <form id="admin-logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            <?php endif; ?>
        </li>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\SRMS\resources\views/layouts/admin-navbar.blade.php ENDPATH**/ ?>