<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addUserForm" method="POST" action="<?php echo e(route('admin.users.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="add-role">Role</label>
                        <select class="form-control" id="add-role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="Student">Student</option>
                            <option value="Faculty & Staff">Faculty & Staff</option>
                        </select>
                    </div>
                    
                    <div id="student-details" style="display: none;">
                        <div class="form-group">
                            <label>Student ID</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                name="student_id" value="<?php echo e(old('student_id')); ?>" required 
                                placeholder="Enter Student ID">
                            <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="add-college">College</label>
                            <select class="form-control" id="add-college" name="college">
                                <option value="">Select College</option>
                                <option value="COE">College of Engineering</option>             
                                <option value="CIT">College of Industrial Technology</option>
                                <option value="CIE">College of Industrial Education</option>
                                <option value="CAFA">College of Architecture and Fine Arts</option>
                                <option value="COS">College of Science</option>
                                <option value="CLA">College of Liberal Arts</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="add-course">Course</label>
                            <select class="form-control" id="add-course" name="course" disabled>
                                <option value="">Select Course</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Year Level</label>
                            <select class="form-control <?php $__errorArgs = ['year_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="year_level" required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year">1st Year</option>
                                <option value="2nd Year">2nd Year</option>
                                <option value="3rd Year">3rd Year</option>
                                <option value="4th Year">4th Year</option>
                                <option value="5th Year">5th Year</option>
                            </select>
                            <?php $__errorArgs = ['year_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="edit-user-id">
                        <div class="form-group">
                            <div class="form-group">
                            <label for="edit-name">Full Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                            <label for="edit-username">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-role">Role</label>
                            <select class="form-control" id="edit-role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Student">Student</option>
                                <option value="Faculty & Staff">Faculty & Staff</option>
                            </select>
                        </div>
                        
                        <div id="edit-student-details" style="display: none;">
                            <div class="form-group">
                                <label>Student ID</label>
                                <input type="text" class="form-control" 
                                    id="edit-student-id" 
                                    name="student_id" 
                                    placeholder="Enter Student ID">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit-college">College</label>
                                <select class="form-control" id="edit-college" name="college">
                                    <option value="">Select College</option>
                                    <option value="COE">College of Engineering</option>             
                                    <option value="CIT">College of Industrial Technology</option>
                                    <option value="CIE">College of Industrial Education</option>
                                    <option value="CAFA">College of Architecture and Fine Arts</option>
                                    <option value="COS">College of Science</option>
                                    <option value="CLA">College of Liberal Arts</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit-course">Course</label>
                                <select class="form-control" id="edit-course" name="course" disabled>
                                    <option value="">Select Course</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Year Level</label>
                                <select class="form-control" id="edit-year-level" name="year_level">
                                    <option value="">Select Year Level</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="5th Year">5th Year</option>
                                </select>
                            </div>
                        </div>
                    </input>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveUserChanges">Save changes</button>
                </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\SRMS\resources\views/admin/modal/usermanagement-modal.blade.php ENDPATH**/ ?>