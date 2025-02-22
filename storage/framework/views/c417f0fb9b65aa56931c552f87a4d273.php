<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <title>Admin - Report</title>
</head>
<body>
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>

</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/admin/admin_report.blade.php ENDPATH**/ ?>