
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Students</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddstudentModal">
        Add Student
    </button>


    
    <button class="exportstu btn btn-warning"> <a href="<?php echo e(route('exportstudents')); ?>"  style="text-decoration: none;color:black">Export Students</a></button>

    <?php if(session('success')): ?>
    <div class="alert alert-success append mt-3
     alert-dismissible fade show"  role="alert">
      <strong><?php echo e(session('success')); ?>  </strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    



    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($students) > 0): ?>
                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($student->id); ?></td>
                        <td><?php echo e($student->name); ?></td>
                        <td><?php echo e($student->email); ?></td>
                        <td>
                            <button class="btn btn-primary editbutton" data-id="<?php echo e($student->id); ?>"
                                data-name="<?php echo e($student->name); ?>" data-email="<?php echo e($student->email); ?>" data-bs-toggle="modal"
                                data-bs-target="#editstudentModal">Edit</button>

                        </td>

                        <td>
                            <button class="btn btn-danger deletebutton" data-id="<?php echo e($student->id); ?>" data-bs-toggle="modal"
                                data-bs-target="#deletestudentModal">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Subject Not Found!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- add-subject-Modal -->
    <div class="modal fade" id="AddstudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addstudentform">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="name" id="" class="form-control"
                            placeholder="Enter Student Name" required>
                        <br>
                        <input type="email" name="email" id="" class="form-control"
                            placeholder="Enter Student Email" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addstud">Add Student</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-add-subject-modal-->

    <!-- edit-student-Modal -->
    <div class="modal fade" id="editstudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editstudentform">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Enter Student Name" required>
                        <br>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Enter Student Emall" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary updatebtn">Update Student</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-edit-student-modal-->




    <!-- Delete-subject-Modal -->
    <div class="modal fade" id="deletestudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deletestudentform">
                        <?php echo csrf_field(); ?>
                        <p>Are you Sure you want to delete this Student! </p>
                        <input type="hidden" name="id" id="delete_stu_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger deletestu">Delete</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- end-delete-subject-modal-->

    <script>
        $(document).ready(function() {

$(".exportstu").click(function(){

    $(".exportstu").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
    setTimeout(() => {
        location.reload();

    }, 700);

});

            $("#addstudentform").submit(function(e) {
                e.preventDefault();
                $(".addstud").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                // $("#loader").show();

                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('addstudent')); ?>",
                    data: formdata,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
            // edit student
            $(".editbutton").click(function() {
                $("#id").val($(this).attr("data-id"));
                $("#name").val($(this).attr("data-name"));
                $("#email").val($(this).attr("data-email"));
            });

            $("#editstudentform").submit(function(e) {

                e.preventDefault();
                $(".updatebtn").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                $(".updatebtn").prop("disabled", true);
                var formdata = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('editstudent')); ?>",
                    data: formdata,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

        })

        // delete student

        $(".deletebutton").click(function() {
            var id = $(this).attr("data-id");
            $("#delete_stu_id").val(id);

        });
        $("#deletestudentform").submit(function(e) {

            var data = $(this).serialize();
            $.ajax({
                type: "post",
                url: "<?php echo e(route('deletestudent')); ?>",
                data: data,
                // dataType: "dataType",
                success: function(data) {
                    if (data == success) {
                        location.reload();
                    } else {
                        alert(data.msg);

                    }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/studentdashboard.blade.php ENDPATH**/ ?>