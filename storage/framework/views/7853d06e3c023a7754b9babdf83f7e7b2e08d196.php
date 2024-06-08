
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Marks</h2>
    <!-- Button trigger modal -->

    <?php if(session('success')): ?>
    <div class="alert alert-success append mt-3
     alert-dismissible fade show"  role="alert">
      <strong><?php echo e(session('success')); ?>  </strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="loader" id="loader" style="display: none"></div>



    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Marks/Q</th>
                <th scope="col">Total Marks</th>
                <th scope="col">Passing Marks</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
<tbody>
<?php if(count($data)>0): ?>
<?php
    $x=1;
?>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($x++); ?></td>
        <td><?php echo e($data->exam_name); ?></td>
        <td><?php echo e($data->marks); ?></td>
        <td><?php echo e(count($data->getqnaexam) * $data->marks); ?></td>
        <td><?php echo e($data->pass_marks); ?></td>
        <td>
            <button class="btn btn-primary editbtn"  data-id="<?php echo e($data->id); ?>" data-pass-marks="<?php echo e($data->pass_marks); ?>" data-marks="<?php echo e($data->marks); ?>" data-totalq="<?php echo e(count($data->getqnaexam)); ?>"  data-bs-toggle="modal" data-bs-target="#editmarksmodal">Edit</button>
        </td>
    </tr>
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <tr>
        <td colspan="5">
            Exams Not Added!

        </td>
    </tr>
<?php endif; ?>
</tbody>
    </table>



       <div class="modal fade" id="editmarksmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editmarks">
                        <?php echo csrf_field(); ?>
                 <div class="row mt-2">
                      <div class="col-sm-4">
                        <label for="">Marks/Q</label>
                      </div>
                      
                      <div class="col-sm-6">
                        <input type="text"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46"
                        id="marks"    name="marks" placeholder="Enter Marks/Q" required>
                        <input type="hidden" name="exam_id" id="exam_id" >
                      </div>
                 </div>

                 
                 <div class="row mt-2">
                    <div class="col-sm-4">
                      <label for="">Total Marks</label>
                    </div>

                    <div class="col-sm-6">
                        <input type="text"  disabled placeholder="Total Marks" id="tmarks">
                      </div>
                 </div>

                    <div class="row mt-2">
                        <div class="col-sm-4">
                          <label for="">Passing Marks</label>
                        </div>

                     <div class="col-sm-6">
                        <input type="text"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46"
                        id="pass_marks"    name="pass_marks" placeholder="Enter passing Marks/Q" required>
                    </div>
                   
               </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editq">edit</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var totalqna=0;
            $('.editbtn').click(function(){
                var exam_id=$(this).attr('data-id');
                var marks=$(this).attr('data-marks');
                var totalq=$(this).attr('data-totalq');
                var passmarks=$(this).attr('data-pass-marks')
                totalqna=totalq;

                $('#exam_id').val(exam_id);
                $('#marks').val(marks);
                $('#tmarks').val((marks*totalq).toFixed(1));
                $("#pass_marks").val(passmarks);
            });

            $("#marks").keyup(function(){
                $('#tmarks').val(($(this).val()* totalqna).toFixed(1));
            });
            $("#pass_marks").keyup(function(){
                var tmarks=$('#tmarks').val();
                var pmarks=$(this).val();
                $('.pass-error').remove();

                if(parseFloat(pmarks) >= tmarks){
                    $(this).parent().append('<p style="color:red" class="pass-error">Passing Marks will be less than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);
                }

            });

            $('#editmarks').submit(function(event){
                event.preventDefault();
                $(".editq").html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                var tmarks=$('#tmarks').val();
                var pmarks=$("#pass_marks").val();
                $('.pass-error').remove();

                if(parseFloat(pmarks) >= tmarks){
                    $("#pass_marks").parent().append('<p style="color:red" class="pass-error">Passing Marks will be less than total marks!</p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);

                    return false;
                }


          var formdata=$(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('updatemarks')); ?>",
                data: formdata,
                // dataType: "dat/aType",
                success: function (data) {
                    location.reload();
                }
            });

            })
        })
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/marksdashboard.blade.php ENDPATH**/ ?>