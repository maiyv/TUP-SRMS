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
    <link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


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
                    echo $greeting . ", " . Auth::guard('admin')->user()->username . "!";
                    ?>
                </h1>
                <p class="lead">Manage service requests and staff assignments</p>
            </div>
        </div>
    </section>

    <?php if(Auth::guard('admin')->user()->role === 'Admin'): ?>
    <!-- STATUS OVERVIEW -->
    <section class="status-overview">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="status-card total">
                        <div class="icon-wrapper">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($requestReceive ?? 0); ?></h3>
                            <p>New Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card pending">
                        <div class="icon-wrapper">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($assignRequest ?? 0); ?></h3>
                            <p>Pending Assignments</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card completed">
                        <div class="icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($servicesCompleted ?? 0); ?></h3>
                            <p>Completed Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="status-card staff">
                        <div class="icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($assignStaff ?? 0); ?></h3>
                            <p>Active Staff</p>
                        </div>
                    </div>
                </div>
               <!-- <div class="col-md-3">
                    <div class="status-card services">
                        <div class="icon-wrapper">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="status-details">
                            <h3 class="service-count">0</h3>
                            <p>Available Services</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- QUICK ACTIONS -->
    <section class="quick-actions">
        <div class="container">
            <div class="action-buttons">
               <!-- <a href="<?php echo e(url('/admin/requests/new')); ?>" class="action-button">
                    <i class="fas fa-plus-circle"></i>
                    <span>Process Requests</span>
                </a> -->
                <a href="<?php echo e(url('/assign-management')); ?>" class="action-button">
                    <i class="fas fa-user-plus"></i>
                    <span>Assign Staff</span>
                </a>
                <a href="<?php echo e(url('/admin_report')); ?>" class="action-button">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
                <a href="<?php echo e(url('/settings')); ?>" class="action-button">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>
    </section>

    <!-- REQUEST STATISTICS CHART -->
    <section class="request-statistics">
        <div class="container">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo e($error); ?>

                </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header">
                    <h3>Request Statistics</h3>
                </div>
                <div class="card-body">
                    <canvas id="requestStatisticsChart"></canvas>
                    
                    <!-- Debug Information -->
                    <div class="mt-3">
                        <strong>Debug Info:</strong>
                        <p>Total Requests: <?php echo e($totalRequests ?? 'N/A'); ?></p>
                        <p>Week Requests: <?php echo e($weekRequests ?? 'N/A'); ?></p>
                        <p>Month Requests: <?php echo e($monthRequests ?? 'N/A'); ?></p>
                        <p>Year Requests: <?php echo e($yearRequests ?? 'N/A'); ?></p>
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
                <a href="<?php echo e(url('/service-request')); ?>" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="request-table-wrapper">
                <table class="request-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Service Type</th>
                            <th>Requester</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentRequests ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>#<?php echo e($request->id); ?></td>
                            <td><?php echo e($request->service_type); ?></td>
                            <td><?php echo e($request->user_name); ?></td>
                            <td><?php echo e($request->created_at->format('M d, Y')); ?></td>
                            <td>
                                <span class="status-badge <?php echo e(strtolower($request->status)); ?>">
                                    <?php echo e($request->status); ?>

                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-view" onclick="window.location.href='<?php echo e(url('/admin/request/'.$request->id)); ?>'">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-edit" onclick="window.location.href='<?php echo e(url('/admin/request/'.$request->id.'/assign')); ?>'">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-inbox fa-3x"></i>
                                <p>No recent requests found</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <?php elseif(Auth::guard('admin')->user()->role === 'UITC Staff'): ?>
    <!-- TECHNICIAN STATUS OVERVIEW -->
    <section class="status-overview">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="status-card assigned">
                        <div class="icon-wrapper">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($assignedRequests ?? 0); ?></h3>
                            <p>Assigned Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="status-card completed">
                        <div class="icon-wrapper">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e($servicesCompleted ?? 0); ?></h3>
                            <p>Completed Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="status-card rating">
                        <div class="icon-wrapper">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="status-details">
                            <h3><?php echo e(number_format($surveyRatings ?? 0, 1)); ?></h3>
                            <p>Average Rating</p>
                            <div class="rating-stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= ($surveyRatings ?? 0) ? 'active' : ''); ?>"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TECHNICIAN QUICK ACTIONS -->
    <section class="quick-actions">
        <div class="container">
            <div class="action-buttons">
                <a href="<?php echo e(url('/assign-request')); ?>" class="action-button">
                    <i class="fas fa-tasks"></i>
                    <span>View Tasks</span>
                </a>
                <a href="<?php echo e(url('/assign-history')); ?>" class="action-button">
                    <i class="fas fa-history"></i>
                    <span>Service History</span>
                </a>
                <a href="<?php echo e(url('/admin_myprofile')); ?>" class="action-button">
                    <i class="fas fa-user-cog"></i>
                    <span>My Profile</span>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>
    <script src="<?php echo e(asset('js/chatbot.js')); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('requestStatisticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Requests', 'This Week', 'This Month', 'This Year'],
                datasets: [{
                    label: 'Number of Requests',
                    data: [
                        <?php echo e($totalRequests ?? 0); ?>, 
                        <?php echo e($weekRequests ?? 0); ?>, 
                        <?php echo e($monthRequests ?? 0); ?>, 
                        <?php echo e($yearRequests ?? 0); ?>

                    ],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.6)',   // Total
                        'rgba(75, 192, 192, 0.6)',   // Week
                        'rgba(255, 99, 132, 0.6)',   // Month
                        'rgba(54, 162, 235, 0.6)'    // Year
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Requests'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Request Statistics Overview'
                    }
                }
            }
        });
    });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SRMS\resources\views/admin/admin_dashboard.blade.php ENDPATH**/ ?>