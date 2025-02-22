<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="<?php echo e(asset('css/service-history.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <title>Service History</title>
</head>
<body>
    
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


 
    <div class="content">
        <h1>History</h1>
    <!--    <p>Welcome, <strong><?php echo e(Auth::user()->username); ?>!</strong></p> -->
       
        <div class="history-table-container">
            <form action="">
                <table class="history-table">
                    <thead>
                       <tr>
                            <th>Request ID</th>
                            <th>Service</th>
                            <th>Date Submitted</th>
                            <th>UITC Staff</th>
                            <th>Date Completed</th>
                            <th>Review and Ratings</th>
                            <th>Actions</th>
                       </tr>
                    </thead>
                    <!--<tbody>
                        <tr>
                            <td>1</td>
                            <td>MS Teams</td>
                            <td>
                                <strong>Date: </strong><span>2024-11-01</span><br>
                                <strong>Time: </strong><span>10:00 AM</span>
                            </td>
                            <td>John Doe</td>
                            <td>
                                <strong>Date: </strong><span>2024-11-04</span><br>
                                <strong>Time: </strong><span>11:30 AM</span>
                            </td>

                            <td><button class="btn-primary">Take a Survey</button></td>

                            <td>
                                <button class="btn-view">View</button>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </form>
        </div>
    </div>

    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?> 

</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/users/request-history.blade.php ENDPATH**/ ?>