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
    <link href="<?php echo e(asset('css/assign-request.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <title>Assignment Request</title>
</head>
<body>
    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.admin-navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.admin-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="content">
        <h1>Assigned Requests</h1>

        <div class="dropdown-container">
            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-input-wrapper">
                    <input type="text" id="user-search" name="user-search" placeholder="Search users...">
                    <i class="fas fa-search search-icon"></i>
                </div>            
            </div>

            <!-- Status Filter -->
            <select name="status" id="status">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="in progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <!-- Transaction Filter -->
            <select name="status" id="status">
                <option value="all">All Transaction</option>
                <option value="simple">Simple Transaction</option>
                <option value="complex">Complex Transaction</option>
                <option value="highly technical">Highly Technical Transaction</option>
            </select>
        </div>

        <div class="assignreq-table-container">
            <h4>Assigned Request List</h4>
            <div class="assignreq-table-wrapper">
                <table class="assignreq-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Request Details</th>
                            <th>Role</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $assignedRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($request->id); ?></td>
                            <td>
                            <?php echo '<strong>Name:</strong> ' . $request->first_name . ' ' . $request->last_name . '<br>' .
                            '<strong>Student ID:</strong> ' . $request->student_id . '<br>' .
                            '<strong>Service:</strong> ' . $request->service_category; ?>

                        </td>
                        <td><?php echo e($request->data_type); ?></td>
                        <td>
                            <strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($request->created_at)->format('Y-m-d')); ?><br>
                            <strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($request->created_at)->format('g:i A')); ?>

                        </td>
                     <td>

                    <span class="badge 
                        <?php if($request->status == 'Pending'): ?> badge-warning
                        <?php elseif($request->status == 'In Progress'): ?> badge-info
                        <?php elseif($request->status == 'Completed'): ?> badge-success
                        <?php else: ?> badge-secondary
                        <?php endif; ?>">
                        <?php echo e($request->status); ?>

                    </span>
                </td>
                <td class="btns">
                    <button class="btn-view" onclick="viewRequestDetails(<?php echo e($request->id); ?>)">View</button>
                    <button class="btn-complete" data-request-id="<?php echo e($request->id); ?>" onclick="completeRequest(<?php echo e($request->id); ?>)">Complete</button>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="empty-state">
                    <i class="fas fa-inbox fa-3x"></i>
                    <p>No assigned requests found</p>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
</table>
            </div>
        </div>
        
    </div>




    <!-- Complete Request Modal -->
<div class="modal fade" id="completeRequestModal" tabindex="-1" role="dialog" aria-labelledby="completeRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeRequestModalLabel">Complete Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="completeRequestForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" id="completeRequestId" name="request_id">
                    
                    <div class="form-group">
                        <label for="completionReport">Completion Report <span class="text-danger">*</span></label>
                        <textarea 
                            class="form-control" 
                            id="completionReport" 
                            name="completion_report" 
                            rows="5" 
                            placeholder="Enter detailed report about the completed request" 
                            required
                        ></textarea>
                        <small class="form-text text-muted">Please provide a comprehensive report of the completed request.</small>
                    </div>

                    <div class="form-group">
                        <label for="actionsTaken">Actions Taken <span class="text-danger">*</span></label>
                        <textarea 
                            class="form-control" 
                            id="actionsTaken" 
                            name="actions_taken" 
                            rows="3" 
                            placeholder="Describe the specific actions taken to complete the request" 
                            required
                        ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="completionStatus">Completion Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="completionStatus" name="completion_status" required>
                            <option value="">Select Completion Status</option>
                            <option value="fully_completed">Fully Completed</option>
                            <option value="partially_completed">Partially Completed</option>
                            <option value="requires_follow_up">Requires Follow-up</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit Completion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal" id="requestCompletedSuccessModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Request has been completed successfully!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
    function completeRequest(requestId) {
        console.log('Complete request called with ID: ' + requestId); // Debug log
        $('#completeRequestId').val(requestId);
        $('#completeRequestModal').modal('show');
    }

    $(document).ready(function() {
    $('#completeRequestForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (this.checkValidity() === false) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        // Get form data
        const formData = $(this).serialize();

        // AJAX call to complete the request
        $.ajax({
            url: '<?php echo e(route("uitc.complete.request")); ?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Close the complete request modal
                $('#completeRequestModal').modal('hide');
                
                // Show success modal
                $('#requestCompletedSuccessModal').modal('show');
            },
            error: function(xhr) {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Failed to complete the request.'
                });
            }
        });
    });

        // Add click event listener to Complete buttons
        $('.btn-complete').on('click', function() {
            const requestId = $(this).data('request-id');
            console.log('Complete button clicked for request ID: ' + requestId);
            completeRequest(requestId);
        });
    });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/uitc_staff/assign-request.blade.php ENDPATH**/ ?>