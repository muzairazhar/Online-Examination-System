
<?php $__env->startSection('space-works'); ?>

    <h1>Paid Exams</h1>
    <?php if(session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucess</strong>         <?php echo e(session('success')); ?>


        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    
<?php endif; ?>

<?php if(session()->has('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>error</strong>         <?php echo e(session('error')); ?>


    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

<?php endif; ?>



<?php if(session()->has('error')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sucess</strong>         <?php echo e(session('error')); ?>


    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

<?php endif; ?>

    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Attempt</th>
            <th>Available Attempt</th>
            <th>Copy Link</th>
        </thead>
        <p>Click <span onclick="alert('Hello!');">here</span> to greet.</p>

        <tbody>
            <?php if(count($exams) > 0): ?>
                <?php
                    $count = 1;
                ?>
                <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="display: none"><?php echo e($exam->id); ?></td>
                        <td><?php echo e($count++); ?></td>
                        <td><?php echo e($exam->exam_name); ?></td>
                        <td><?php echo e($exam->subjects['0']['subject']); ?></td>
                        <td><?php echo e($exam->date); ?></td>
                        <td><?php echo e($exam->time); ?> Hrs</td>
                        <td><?php echo e($exam->attempt); ?> Time</td>
                        <td><?php echo e($exam->attempt_counter); ?></td>
                       
                                     <?php if(count($exam->getpaidinfo)>0 && $exam->getpaidinfo[0]['user_id']==auth()->user()->id): ?>
                                     <td><a href="#"  data-code="<?php echo e($exam->enterance_id); ?>"><i class="fa fa-copy "></i></a></td>
                                         <?php else: ?>
                                         <td> <b><a href="#" style="color: red;text-decoration:none" class="buynow"
                                            data-prices="<?php echo e($exam->prices); ?>" data-id="<?php echo e($exam->id); ?>"  data-bs-toggle="modal" data-bs-target="#buymodel"> Buy
                                            Now</a></b>
                                        </td>
                                     <?php endif; ?>


                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="8"> No Exams Available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="modal fade" id="buymodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Buy Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="buyform"  action="<?php echo e(route('paymentpkr')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="exam_id" id="exam_id">
                        <select name="price" class="form-control" id="price" required >
                        </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning submitbtn">Buy now</button>
                </div>
                </form>

            </div>
         
        </div>
    </div>
    <script>
    var ispkr=false;
        $(document).ready(function() {

            $(".buynow").click(function() {
                var prices = JSON.parse($(this).attr('data-prices'));
                var html = '';
                html += `
              
              <option value="">Select  Currency(Price)</option>
              <option value="` + prices.PKR + `">PKR: ` + prices.PKR + `</option>
              `;

                $("#price").html(html);
                
            });
            $(".buynow").click(function(){
              var id=  $(this).attr('data-id');
              $("#exam_id").val(id);
            });

            $('.fa-copy').click(function(){
            $(this).parent().append('<span class="copytext">Copied</span>');
            var code=$(this).parent().attr('data-code');
            console.log(code)
            var url="<?php echo e(URL::to('/')); ?>/exam/"+code;
           var $temp=$("<input>");
           $("body").append($temp);

           $temp.val(url).select();
           document.execCommand('copy');
           $temp.remove();



            setTimeout(() => {
               $(".copytext").remove(); 
            }, 1000);
        });
 
            
               
            

            
            $("#price").change(function() { 

                var price = $("#price").val();
                if(price.includes('PKR')){
                    ispkr=true;

                }else{
                    ispkr=false;
                }
            });







        })

    </script>

   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.studentlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/paidexams.blade.php ENDPATH**/ ?>