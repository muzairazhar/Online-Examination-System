
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Subjects</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddstudentModal">
  Add Student
</button>
<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

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
  <?php if(count($students)>0): ?>
<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($student->id); ?></td>
        <td><?php echo e($student->name); ?></td>
        <td><?php echo e($student->email); ?></td>
        <td>
          <button class="btn btn-primary editbutton" data-id="<?php echo e($student->id); ?>"  data-bs-toggle="modal" data-bs-target="#editsubjectModal">Edit</button>

        </td>

        <td>
          <button class="btn btn-danger deletebutton" data-id="<?php echo e($student->id); ?>"  data-bs-toggle="modal" data-bs-target="#deletesubjectModal">Delete</button>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
      <tr><td colspan="4">Subject Not Found!</td></tr>
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
            <input type="text" name="name" id="" class="form-control" placeholder="Enter Student Name" required>
            <br>
            <input type="email" name="email" id="" class="form-control" placeholder="Enter Student Emall" required>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Student</button>
      </div>
    </form>

    </div>
  </div>
</div>
<!-- end-add-subject-modal-->

<!-- edit-subject-Modal -->

<!-- end-edit-subject-modal-->


<!-- Delete-subject-Modal -->

  
<!-- end-delete-subject-modal-->

    <script>
        $(document).ready(function() {
            $("#addstudentform").submit(function(e) {
                e.preventDefault();
               var formdata = $(this).serialize();
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


    
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/studentdashboard.blade.php ENDPATH**/ ?>