
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Subjects</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddsubjectModal">
  Add Subject
</button>
<?php if(session('success')): ?>
<div class="alert alert-success append mt-3 alert-dismissible fade show"  role="alert">
  <strong><?php echo e(session('success')); ?>  </strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<table class="table mt-3">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Subject</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
  <?php if(count($subjects)>0): ?>
<?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($subject->id); ?></td>
        <td><?php echo e($subject->subject); ?></td>
        <td>
          <button class="btn btn-primary editbutton" data-id="<?php echo e($subject->id); ?>" data-subject="<?php echo e($subject->subject); ?>" data-bs-toggle="modal" data-bs-target="#editsubjectModal">Edit</button>

        </td>

        <td>
          <button class="btn btn-danger deletebutton" data-id="<?php echo e($subject->id); ?>" data-subject="<?php echo e($subject->subject); ?>" data-bs-toggle="modal" data-bs-target="#deletesubjectModal">Delete</button>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
      <tr><td colspan="4">Subject Not Found!</td></tr>
  <?php endif; ?>
    </tbody>
  </table>

<!-- add-subject-Modal -->
<div class="modal fade" id="AddsubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addsubject">
            <?php echo csrf_field(); ?>
            <input type="text" name="subject" id="" class="form-control" placeholder="Enter Subject Name" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary addsub">Add Subject</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-add-subject-modal-->

<!-- edit-subject-Modal -->
<div class="modal fade" id="editsubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editsubject">
            <?php echo csrf_field(); ?>
            <label for="" class="form label">Subject</label>
            <input type="text" name="subject" id="edit-subject" class="form-control" id="edit_subject" placeholder="Enter subject name" required>
            <input type="hidden"  name="id" id="edit_sub_id"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary editsub">Update</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-edit-subject-modal-->


<!-- Delete-subject-Modal -->
<div class="modal fade" id="deletesubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="deletesubject">
            <?php echo csrf_field(); ?>
           <p>Are you Sure you want to delete this Subject! </p>
            <input type="hidden"  name="id" id="delete_sub_id"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger delsub">Delete</button>
      </div>
    </form>

    </div>
  </div>
</div><!-- end-delete-subject-modal-->

    <script>
        $(document).ready(function() {
            $("#addsubject").submit(function(e) {
                e.preventDefault();
                $(".addsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('addsubject')); ?>",
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

            // edit subject

            $(".editbutton").click(function(){
               var subject_id=$(this).attr("data-id");
              var subject_name=$(this).attr("data-subject");
              $("#edit-subject").val(subject_name);
              $("#edit_sub_id").val(subject_id);
              
            })
            $("#editsubject").submit(function(e) {
                e.preventDefault();
                $(".editsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('editsubject')); ?>",
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

            // Delete subject
            $(".deletebutton").click(function(){
              var subject_id=$(this).attr("data-id");
              $("#delete_sub_id").val(subject_id);
            });

            $("#deletesubject").submit(function(e) {
                e.preventDefault();
                $(".delsub").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formdata = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(route('deletesubject')); ?>",
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

<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>