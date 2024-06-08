
<?php $__env->startSection('space-works'); ?>

    <h1>Free Exams</h1>
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
        <p>Click <span onclick="alert('Hello! Welcome Student');">here</span> to greet.</p>

        <tbody>
            <?php if(count($exams) > 0): ?>
                <?php
                    $count = 1;
                ?>
                <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                        $exam->id;
                            $package = json_decode(json_encode($exam->package), true);
                            $expiry = '';
                            foreach ($package as $data) {
                                $expiry = $data['exapire'];
                            }
                        ?>
                        <?php if($exam->is_package_exam !=true || date('Y-m-d') > $expiry): ?>
                        <tr>
                            <td><?php echo e($count++); ?></td>
                            <td><?php echo e($exam->exam_name); ?></td>
                            <td><?php echo e($exam->subjects['0']['subject']); ?></td>
                            <td><?php echo e($exam->date); ?></td>
                            <td><?php echo e($exam->time); ?> Hrs</td>
                            <td><?php echo e($exam->attempt); ?> Time</td>
                            <td><?php echo e($exam->attempt_counter); ?></td>
                            <td><a href="#" data-code="<?php echo e($exam->enterance_id); ?>"><i class="fa fa-copy "></i></a></td>
    
                        </tr>

                        <?php else: ?>
                        <tr>
                            <td><?php echo e($count++); ?></td>
                            <td><?php echo e($exam->exam_name); ?></td>
                            <td><?php echo e($exam->subjects['0']['subject']); ?></td>
                            <td><?php echo e($exam->date); ?></td>
                            <td><?php echo e($exam->time); ?> Hrs</td>
                            <td><?php echo e($exam->attempt); ?> Time</td>
                            <td><?php echo e($exam->attempt_counter); ?></td>
                            <td><a href="#" data-code="<?php echo e($exam->enterance_id); ?>"><i class="fa fa-copy "></i></a></td>
    
                        </tr>
                        <?php endif; ?>
                  

                   
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="8"> No Exams Available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('.fa-copy').click(function() {
                $(this).parent().append('<span class="copytext">Copied</span>');
                var code = $(this).parent().attr('data-code');
                console.log(code)
                var url = "<?php echo e(URL::to('/')); ?>/exam/" + code;
                var $temp = $("<input>");
                $("body").append($temp);

                $temp.val(url).select();
                document.execCommand('copy');
                $temp.remove();



                setTimeout(() => {
                    $(".copytext").remove();
                }, 1000);
            });

        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.studentlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/dashboard.blade.php ENDPATH**/ ?>