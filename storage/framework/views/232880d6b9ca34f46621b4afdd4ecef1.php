<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet" />
    <link href="<?php echo e(asset('css/login.css')); ?>" rel="stylesheet">
    <title>SRMS Login</title>
</head>
<body>
    <div class="container login-container">
        <img src="<?php echo e(asset('images/tuplogo.png')); ?>" class="tuplogo" alt="TUP Logo">
        <h3 class="text-center">Sign In</h3>

        <!-- Display error message if login fails -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.custom')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="<?php echo e(route('password.request')); ?>" class="text-white">Forgot Password?</a>
                    </div>
                </div>
            </div>

            <button type="submit" class="login-btn btn-primary btn-block">Sign In</button>
         
        </form>

        <!-- OR separator -->
        <div class="separator">
            <span>-- OR --</span>
        </div>

        <!-- Google Login Link -->
        <div class="text-center mt-3">
            <a href="<?php echo e(route('login.google')); ?>" class="btn btn-outline-google">
                <img src="<?php echo e(asset('images/google.png')); ?>" alt="Google Logo" class="google-icon">Login with Google
            </a>
        </div>

        <!-- Register Link -->
        <div class="register-link">
            Don't have an account? 
            <a href="<?php echo e(route('register')); ?>" class="bold-text">Sign up</a>
        </div>
    </div>


</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\SRMS\resources\views/login.blade.php ENDPATH**/ ?>