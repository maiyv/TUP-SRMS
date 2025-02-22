<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">  <!-- Add this line -->
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="<?php echo e(Auth::check() ? 'user-authenticated' : ''); ?>">
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>
                    <?php
                    date_default_timezone_set('Asia/Manila');
                    $hour = date('H');
                    $greeting = ($hour >= 5 && $hour < 12) ? "Good Morning" :
                               (($hour >= 12 && $hour < 18) ? "Good Afternoon" : "Good Evening");
                    echo $greeting . ", " . Auth::user()->username . "!";
                    ?>
                </h1>
                <p class="lead">Track and manage your service requests</p>
            </div>
        </div>
    </section>

    <!-- QUICK ACTIONS -->
    <section class="quick-actions">
        <div class="container">
            <div class="action-buttons">
            <?php if(Auth::user()->role === 'Student'): ?>
                <a href="<?php echo e(url('/student-request')); ?>" class="action-button">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Request</span>
                </a>
              <?php else: ?>
                 <a href="<?php echo e(url('/faculty-service')); ?>" class="action-button">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Faculty Request</span>
                </a>
              <?php endif; ?>

                <a href="<?php echo e(url('/myrequests')); ?>" class="action-button">
                    <i class="fas fa-list-alt"></i>
                    <span>My Requests</span>
                </a>
                <a href="<?php echo e(url('/help')); ?>" class="action-button">
                    <i class="fas fa-question-circle"></i>
                    <span>Help Guide</span>
                </a>
            </div>
        </div>
    </section>

    <!-- STATUS OVERVIEW -->
    <section class="status-overview">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="status-card total">
                        <div class="icon-wrapper">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($totalRequests ?? 0); ?></h3>
                            <p>Total Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card pending">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($pendingRequests ?? 0); ?></h3>
                            <p>Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card processing">
                        <div class="icon-wrapper">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($inprogressRequests ?? 0); ?></h3>
                            <p>In Progress</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card completed">
                        <div class="icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($completedRequests ?? 0); ?></h3>
                            <p>Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RECENT REQUESTS -->
    <section class="recent-requests">
        <div class="container">
            <div class="section-header">
                <h2>Recent Requests</h2>
                <a href="<?php echo e(url('/myrequests')); ?>" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="request-table-wrapper">
                <table class="request-table">
                    <thead>
                        <tr>
                             <th>Request ID</th>
                             <th>Service Type</th>
                            <th>Date Submitted</th>
                            <th>Last Update</th>
                            <th>Status</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                             <td><?php echo e($request['id']); ?></td>
                             <td><?php echo e($request['service_type']); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($request['created_at'])->format('M d, Y h:i A')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($request['updated_at'])->format('M d, Y h:i A')); ?></td>
                            <td>
                                <span class="badge
                                    <?php if($request['status'] == 'Pending'): ?> badge-warning
                                    <?php elseif($request['status'] == 'In Progress'): ?> badge-info
                                    <?php elseif($request['status'] == 'Completed'): ?> badge-success
                                     <?php elseif($request['status'] == 'Rejected'): ?> badge-danger
                                    <?php else: ?> badge-secondary
                                    <?php endif; ?>">
                                    <?php echo e($request['status']); ?>

                                </span>
                            </td>
                             <td>
                                 <a href="<?php if($request['type'] === 'student'): ?> <?php echo e(route('student.myrequests.show', $request['id'])); ?> <?php else: ?> <?php echo e(route('faculty.myrequests.show', $request['id'])); ?> <?php endif; ?>" class="btn-view">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                          <td colspan="5" class="text-center"> No recent requests found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- SERVICE CATEGORIES -->
    <section class="service-categories">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Available Services</h2>
                        </div>
                        <div class="card-body p-0">
                            <div class="category-grid service-list">
                                <!-- Services will be loaded here dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>
    <script src="<?php echo e(asset('js/chatbot.js')); ?>"></script>
    <script src="<?php echo e(asset('js/service-dashboard.js')); ?>"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/users/dashboard.blade.php ENDPATH**/ ?>