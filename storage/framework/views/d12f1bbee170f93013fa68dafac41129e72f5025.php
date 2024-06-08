
<?php $__env->startSection('space-work'); ?>
    <?php
        $time = explode(':', $exam[0]['time']);
    ?>
    <div class="container">
        
        <p style="color:black"><span>Welcome, <?php echo e(Auth::user()->name); ?></span></p>
        <h1 class="text-center "><?php echo e($exam[0]['exam_name']); ?></h1>
        <h4 class="text-end time" ><?php echo e($exam[0]['time']); ?></h4>
         <?php
            $qcount = 1;
        ?>
        
        <?php if($success == true): ?>
           <?php if(count($qna) > 0): ?>
                <form action="<?php echo e(url('/exam-submit')); ?>" method="post" class="mb-5"  id="exam_form"  >
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="exam_id" value="<?php echo e($exam[0]['id']); ?>">

                    <?php $__currentLoopData = $qna; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <h5>Q.<?php echo e($qcount++); ?> <?php echo e($data['question'][0]['questions']); ?> </h5>
                            <input type="hidden" name="q[]" value="<?php echo e($data['question'][0]['id']); ?>" id="">
                            <input type="hidden" name="ans_<?php echo e($qcount - 1); ?>" id="ans_<?php echo e($qcount - 1); ?>"
                                class="sans">

                            <?php
                                $acount = 1;
                            ?>
                            <?php $__currentLoopData = $data['question'][0]['answer']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><b> <?php echo e($acount++); ?>)</b> <?php echo e($answer['answer']); ?>

                                    <input type="radio" class="select_ans" name="radio_<?php echo e($qcount - 1); ?>"
                                        id="ans   _<?php echo e($qcount - 1); ?>" value="<?php echo e($answer['id']); ?>"
                                        data-id="<?php echo e($qcount - 1); ?>">
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center">
                        <input type="submit" class="btn btn-info">
                    </div>
                </form>
            <?php else: ?>
                <h3 style="color: red" class="text-center">Questions & Answer not available!</h3>
            <?php endif; ?>
        <?php else: ?>
            <h3 style="color: red" class="text-center"><?php echo e($msg); ?></h3>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function() {
            $(".select_ans").click(function() {
                var id = $(this).attr('data-id');
                $("#ans_" + id).val($(this).val());
            });


            var time = <?php echo json_encode($time, 15, 512) ?>;
            console.log(time);
            $(".time").text(time[0]+':::::'+time[1]+': 00 Left time');
            var second= 9;
            var hours=parseInt(time[0]);
            var minutes= parseInt(time[1]);

            var timer = setInterval(() => {

               if(hours == 0 && minutes == 0 && second == 0){
                clearInterval(timer);
                
                $("#exam_form").submit();

               }


               console.log(hours+" -:- "+minutes+" -:- "+second);

                if(second <= 0){
                    minutes--;
                    second = 59;
                }


                if(minutes<=0 && hours !=0){
                    hours--;
                    minutes=60;
                    second=59;
                }
                 
                var temphours=hours.toString().length>1?hours:'0'+hours;
                var tempmint=minutes.toString().length>1?minutes:'0'+minutes;
                var tempsec=second.toString().length>1?second:'0'+second;


                $(".time").text(temphours+':'+tempmint+': '+ tempsec+' Left time');

                second--;


            }, 1000);
            


        });

        function isvalid() {
            var result = true;
            var qlength = parseInt("<?php echo e($qcount); ?>") - 1;
             console.log(qlength);

            for (i = 1; i <= qlength; i++) {
                if ($("#ans_" + i).val() == "") {
                    result = false;
                    $("#ans_" + i).parent().append("<span style='color:red' class='error_msg'>Please Select Answer</span>");
                    setTimeout(() => {
                        $(".error_msg").remove();
                    }, 50000);
                }
                // alert(i);
            }
            return result;

        }
    </script> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/exam-dashboard.blade.php ENDPATH**/ ?>