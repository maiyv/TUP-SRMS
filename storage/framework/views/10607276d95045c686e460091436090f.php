<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="sidebar">
    <div class="logo_item">
        <a href="<?php echo e(url('/admin_dashboard')); ?>">
            <img src="<?php echo e(asset('images/tuplogo.png')); ?>" alt="Logo" class="logo">
        </a>      
        <span class="sidebar-title">TUP SRMS</span>
    </div>

    <div class="menu_content">
        <ul class="menu_items">
            <!-- Dashboard Link -->
            <li class="item">
                <a href="<?php echo e(url('/dashboard')); ?>" class="nav_link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">
                    <span class="navlink_icon">
                        <i class="bx bxs-dashboard"></i>
                    </span>
                    <span class="navlink">Dashboard</span>
                </a>
            </li>

            <!-- Conditional Submit Request Link for students and faculty/staff -->
            <?php if(auth()->user()->role == 'Student'): ?>
                <li class="item">
                    <a href="<?php echo e(url('/student-request')); ?>" class="nav_link <?php echo e(request()->is('student-request') ? 'active' : ''); ?>">
                        <span class="navlink_icon">
                            <i class="bx bxs-check-circle"></i>
                        </span>
                        <span class="navlink">Submit Request</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="item">
                    <a href="<?php echo e(url('/faculty-service')); ?>" class="nav_link <?php echo e(request()->is('faculty-service') ? 'active' : ''); ?>">
                        <span class="navlink_icon">
                            <i class="bx bxs-check-circle"></i>
                        </span>
                        <span class="navlink">Submit Request</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- My Requests Link -->
            <li class="item">
                <a href="<?php echo e(url('/myrequests')); ?>" class="nav_link <?php echo e(request()->is('myrequests') ? 'active' : ''); ?>">
                    <span class="navlink_icon">
                        <i class="bx bxs-book-open"></i>
                    </span>
                    <span class="navlink">My Requests</span>
                </a>
            </li>

            <!-- Service History Link -->
            <li class="item">
                <a href="<?php echo e(url('/request-history')); ?>" class="nav_link <?php echo e(request()->is('request-history') ? 'active' : ''); ?>">
                    <span class="navlink_icon">
                        <i class="bx bx-history"></i>
                    </span>
                    <span class="navlink">Request History</span>
                </a>
            </li>

            <!-- Messages Link 
            <li class="item">
                <a href="<?php echo e(url('/messages')); ?>" class="nav_link <?php echo e(request()->is('messages') ? 'active' : ''); ?>">
                    <span class="navlink_icon">
                        <i class="bx bxs-chat"></i>
                    </span>
                    <span class="navlink">Messages</span>
                </a>
            </li> -->

            <!-- Help Link -->
            <li class="item">
                <a href="<?php echo e(url('/help')); ?>" class="nav_link <?php echo e(request()->is('help') ? 'active' : ''); ?>">
                    <span class="navlink_icon">
                        <i class="bx bxs-help-circle"></i>
                    </span>
                    <span class="navlink">Help</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\SRMS\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>