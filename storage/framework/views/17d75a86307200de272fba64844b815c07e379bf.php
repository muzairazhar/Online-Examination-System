
<?php $__env->startSection('space-works'); ?>

    <h2 class="mb-4"> Review Exams</h2>
    <?php if(session('success')): ?>

<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    <strong>Success</strong>  <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Review</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count=1;
                ?>
                <?php if(count($attempt) > 0): ?>
                    <?php $__currentLoopData = $attempt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                    <tr>
                        <td><?php echo e($count++); ?></td>
                        <td><?php echo e($attempt->user[0]['name']); ?></td>
                        <td><?php echo e($attempt->exam[0]['exam_name']); ?></td>
                        <td>
                            <?php if($attempt->status ==0): ?>
                                <span style="color: red">Pending</span>
                            <?php else: ?>
                            <span style="color: darkgreen">Approved</span>
                                
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($attempt->status == 0): ?>
                            <a href="#"  style="text-decoration: none" data-id="<?php echo e($attempt->id); ?>"  class="reviewbtn" data-bs-toggle="modal" data-bs-target="#reviewexammodal">Review & Approved</a>
                            <?php else: ?>
                               Completed                                
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Students Not Attempt Exams!</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

<!-- Modal -->
<div class="modal fade" id="reviewexammodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form  id="reviewform">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="attempt_id" name="attempt_id">
        <div class="modal-body review-exam">
          loading....
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary  approvedbtn" >Approved</button>
        </div>
    </form>
      </div>
    </div>
  </div>


  <script>
   $(document).ready(function(){
    $(".reviewbtn").click(function(){
        var id=$(this).attr('data-id');
        $("#attempt_id").val(id);
        $.ajax({
            type: "GET",
            url: "<?php echo e(route('reviewqnaa')); ?>",
            data: {attempt_id:id},
            success: function (data) {
                // console.log(data.data);
                   
                var html='';
                if(data.success==true){
                    // console.log(data.data);
                    var data=data.data;
                    if(data.length>0){
                        for(var i=0; i < data.length; i++){

                         var iscorrect='<span  style="color:red;" class="fa fa-close"></span>';

                              if(data[i]['answer']['is_correct']==1){
                              iscorrect='<span  style="color:green;" class="fa fa-check"></span>';

                              }

                              var answer=data[i]['answer']['answer']; 
                              html+=`
                                          <div class="row">
                                             <div class="col-sm-12">
                                                 <h6>Q(`+(i+1)+`).`+data[i]['question']['questions']+`</h6>
                                                 <p>Ans:-`+answer+` `+iscorrect+`  <p>
                                             </div>
                                             </div>
                                   
                                          `;
                                            
                        }
                    } else{
                            html+=`<h6>Student not attempt any Question!</h6>
                                    <p>if you approve this exam student will fail</p>
                            `;

                        }
 
                }else{
                 html+=`<p>Having Some Server Issue!</p>`

                }

                $('.review-exam').html(html);


            }
        });

    });

    $("#reviewform").submit(function(e){
           e.preventDefault();
           $(".approvedbtn").html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

            var formdata=$(this).serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('approvedqna')); ?>",
                data: formdata,
                success: function (data) {
                    location.reload();

                    console.log(data.data);
                    // if(data.success==true){
                    // }
                }
            });
    })  

   })
  </script>
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/reviewexam.blade.php ENDPATH**/ ?>