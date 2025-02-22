<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('images/tuplogo.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="<?php echo e(asset('css/myrequest.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-sidebar.css')); ?>" rel="stylesheet">
    <script>
$(document).ready(function() {
    // View request details
    $('.btn-view').click(function() {
        const id = $(this).data('id');
        $.get(`/faculty/request/${id}`, function(data) {
            $('#viewServiceName').text(data.service_category);
            $('#viewServiceStatus').text(data.status);
            
            // Add more fields as needed
            const modalBody = $('#viewServiceModal .modal-body');
            modalBody.html(`
                <p><strong>Request ID:</strong> ${data.id}</p>
                <p><strong>Service:</strong> ${data.service_category}</p>
                <p><strong>Status:</strong> ${data.status}</p>
                <p><strong>First Name:</strong> ${data.first_name}</p>
                <p><strong>Last Name:</strong> ${data.last_name}</p>
                <p><strong>Date Submitted:</strong> ${new Date(data.created_at).toLocaleDateString()}</p>
                ${data.ms_options ? `<p><strong>MS Options:</strong> ${JSON.parse(data.ms_options).join(', ')}</p>` : ''}
                ${data.description ? `<p><strong>Description:</strong> ${data.description}</p>` : ''}
            `);
            
            $('#viewServiceModal').modal('show');
        });
    });

    // Delete request
    $('.btn-delete').click(function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this request?')) {
            $.ajax({
                url: `/faculty/request/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting request');
                }
            });
        }
    });

    // Filter by status
    $('#status-filter').change(function() {
        const status = $(this).val().toLowerCase();
        $('.request-table tbody tr').each(function() {
            const rowStatus = $(this).find('td:eq(3)').text().toLowerCase();
            $(this).toggle(status === '' || rowStatus.includes(status));
        });
    });

    // Search functionality
    $('#search-input').keyup(function() {
        const searchText = $(this).val().toLowerCase();
        $('.request-table tbody tr').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchText));
        });
    });
});
</script>
    <title>My Requests</title>
</head>
<body>

    <!-- Include Navbar -->
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Include Sidebar -->
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="content">
        <h1>My Request</h1>
        <div class="form-container">
            <div class="dropdown-container">
            <select name="" id="">
                <option value="pending">Pending</option>
                <option value="in progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" name="" placeholder="Search...">
                <button class="search-btn" type="button" onclick="performSearch()">Search</button>
            </div>
        </div>
            
            <div class="request-table-container">
                <form action="">
                    <table class="request-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Service</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($request->id); ?></td>
                                <td>
                                <?php switch($request->service_category):
                                    case ('create'): ?>
                                        <?php if($request->service_category == 'create'): ?>
                                            Create MS Office/TUP Email Account
                                        <?php endif; ?>
                                    <?php case ('reset_email_password'): ?>
                                        <?php if($request->service_category == 'reset_email_password'): ?>
                                            Reset MS Office/TUP Email Password
                                        <?php endif; ?>
                                    <?php case ('change_of_data_ms'): ?>
                                        <?php if($request->service_category == 'change_of_data_ms'): ?>
                                            Change of Data (MS Office)
                                        <?php endif; ?>
                                    <?php case ('reset_tup_web_password'): ?>
                                        <?php if($request->service_category == 'reset_tup_web_password'): ?>
                                            Reset TUP Web Password
                                        <?php endif; ?>
                                    <?php case ('change_of_data_portal'): ?>
                                        <?php if($request->service_category == 'change_of_data_portal'): ?>
                                            Change of Data (Portal)
                                        <?php endif; ?>
                                    <?php case ('request_led_screen'): ?>
                                        <?php if($request->service_category == 'request_led_screen'): ?>
                                            LED Screen Request
                                        <?php endif; ?>
                                    <?php case ('others'): ?>
                                        <?php if($request->service_category == 'others'): ?>
                                            <?php echo e($request->description); ?>

                                        <?php endif; ?>
                                    <?php default: ?>
                                        <?php echo e($request->service_category); ?>

                                <?php endswitch; ?>
                                </td>
                                    <td><?php echo e(\Carbon\Carbon::parse($request->created_at)->format('M d, Y')); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if($request->status == 'Pending'): ?> badge-warning
                                            <?php elseif($request->status == 'In Progress'): ?> badge-info
                                            <?php elseif($request->status == 'Approved'): ?> badge-success
                                            <?php elseif($request->status == 'Rejected'): ?> badge-danger
                                            <?php else: ?> badge-secondary
                                            <?php endif; ?>">
                                        <?php echo e($request->status); ?>

                                            </span>
                                    </td>
                                    <td>
                                    <button type="button" class="btn-edit" data-id="<?php echo e($request->id); ?>">Edit</button>
                                    <button type="button" class="btn-view" data-id="<?php echo e($request->id); ?>">View</button>
                                    <button type="button" class="btn-delete" data-id="<?php echo e($request->id); ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>



    <!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editServiceForm">
                    <input type="hidden" id="editServiceId">
                    <div class="form-group">
                        <label>Service Name</label>
                        <input type="text" class="form-control" id="editServiceName" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="editServiceDescription" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveEditedService()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- View Service Modal -->
<div class="modal fade" id="viewServiceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Service</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Service:</strong> <span id="viewServiceName"></span></p>
                <p><strong>Status:</strong> <span id="viewServiceStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Service Modal -->
<div class="modal fade" id="deleteServiceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Service</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this service?</p>
                <input type="hidden" id="deleteServiceId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteService()">Delete</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('js/navbar-sidebar.js')); ?>" defer></script>
   <script>
      $(document).ready(function() {
            // Edit Button: Populate Edit Modal
            $('.request-table').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                const service = $(this).closest('tr').find('td:nth-child(2)').text();
                
                $('#editServiceId').val(id);
                $('#editServiceName').val(service);
                $('#editServiceDescription').val('');
                $('#editServiceModal').modal('show');
            });

            // View Button: Populate View Modal
            $('.request-table').on('click', '.btn-view', function() {
                const service = $(this).closest('tr').find('td:nth-child(2)').text();
                const status = $(this).closest('tr').find('td:nth-child(4)').text();
                
                $('#viewServiceName').text(service);
                $('#viewServiceStatus').text(status);
                $('#viewServiceModal').modal('show');
            });

            // Delete Button: Populate Delete Modal
            $('.request-table').on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                $('#deleteServiceId').val(id);
                $('#deleteServiceModal').modal('show');
            });

            // Save Edited Service (Function Example)
            function saveEditedService() {
                const id = $('#editServiceId').val();
                const serviceName = $('#editServiceName').val();
                const description = $('#editServiceDescription').val();

                // AJAX or form submission logic here
                window.location.href = `/editrequest/${id}?service=${encodeURIComponent(serviceName)}&description=${encodeURIComponent(description)}`;
            }

            // Confirm Delete Service (Function Example)
            function confirmDeleteService() {
                const id = $('#deleteServiceId').val();

                // AJAX or deletion logic here
                window.location.href = `/deleterequest/${id}`;
            }

            // Attach click handlers to modal action buttons
            $('#editServiceModal').on('click', '.btn-primary', saveEditedService);
            $('#deleteServiceModal').on('click', '.btn-danger', confirmDeleteService);
        });
        
        $(document).ready(function() {
        // Filter by Status (Dropdown)
        $('select').on('change', function() {
            const selectedStatus = $(this).val().toLowerCase();
            $('.request-table tbody tr').each(function() {
                const rowStatus = $(this).find('td:nth-child(4)').text().toLowerCase();
                if (rowStatus.includes(selectedStatus) || selectedStatus === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Search by Service Name
        $('.search-btn').on('click', function() {
            const searchTerm = $('input[type="text"]').val().toLowerCase();
            $('.request-table tbody tr').each(function() {
                const serviceName = $(this).find('td:nth-child(2)').text().toLowerCase();
                if (serviceName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Optional: Add "Enter" key functionality for the search bar
        $('input[type="text"]').on('keypress', function(e) {
            if (e.which === 13) {
                $('.search-btn').click();
            }
        });
    });
    </script>
    <script src="<?php echo e(asset('js/myrequests.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/users/myrequests.blade.php ENDPATH**/ ?>