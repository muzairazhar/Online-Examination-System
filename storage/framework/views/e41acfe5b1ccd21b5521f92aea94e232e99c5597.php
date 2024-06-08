
<?php $__env->startSection('space-works'); ?>
    <h2 class="mb-4">Packages</h2>
    <!-- Button trigger modal -->


    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>Success</strong> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table mt-5 table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Package Name</th>
                <th>Exams</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Buy Package</th>
            </tr>
        </thead>
        <?php
            $sr = 1;
        ?>
        <?php if(count($paidpackage) > 0): ?>
            <tbody>

                <?php $__currentLoopData = $paidpackage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $exams = '';
                        $packageid = $package->id;
                        foreach ($package->exam_id as $exam) {
                            $exams .= $exam->exam_name . ',';
                        }
                    ?>

                    <?php if($package->is_paid == false): ?>
                        <tr>
                            <td><?php echo e($sr++); ?></td>
                            <td><?php echo e($package->name); ?></td>
                            <td>
                                <?php echo e($exams); ?>

                            </td>
                            <td>
                                <?php
                                    $price = json_decode($package->price);
                                ?>
                                <?php $__currentLoopData = $price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($key); ?> : <?php echo e($p); ?><br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($package->exapire); ?></td>
                            <td>

                                <?php if($package->exapire >= date('Y-m-d')): ?>
                                    <b><a href="#" style="color: red;text-decoration:none" class="buynow"
                                            data-bs-toggle="modal" data-bs-target="#buymodel"
                                            data-price="<?php echo e($package->price); ?>" data-id="<?php echo e($package->id); ?>"> Buy
                                            Now</a></b>
                                <?php else: ?>
                                    <b>Expired</b>
                                <?php endif; ?>
                            </td>
                        
                        <?php else: ?>
                        


                    <?php endif; ?>


                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>
        <?php else: ?>
        
            <td colspan="4">No Packages Found!</td>
        
        <?php endif; ?>
    </table>

    
    <div class="modal fade" id="buymodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Buy Exam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="buyform" action="<?php echo e(route('packagepayment')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="package_id" id="package_id">
                        <select name="price" class="form-control" id="price" required>
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
        var ispkr = false;
        $(document).ready(function() {

            $(".buynow").click(function() {
                var prices = JSON.parse($(this).attr('data-price'));
                var html = '';
                html += `
              
              <option value="">Select  Currency(Price)</option>
              <option value="` + prices.PKR + `">PKR: ` + prices.PKR + `</option>
              `;

                $("#price").html(html);

            });

            $(".buynow").click(function() {
                var id = $(this).attr('data-id');
                $("#package_id").val(id);
            });




            //     $('.fa-copy').click(function(){
            //     $(this).parent().append('<span class="copytext">Copied</span>');
            //     var code=$(this).parent().attr('data-code');
            //     console.log(code)
            //     var url="<?php echo e(URL::to('/')); ?>/exam/"+code;
            //    var $temp=$("<input>");
            //    $("body").append($temp);

            //    $temp.val(url).select();
            //    document.execCommand('copy');
            //    $temp.remove();



            //     setTimeout(() => {
            //        $(".copytext").remove(); 
            //     }, 1000);
            // });






            // $("#price").change(function() { 

            //     var price = $("#price").val();
            //     if(price.includes('PKR')){
            //         ispkr=true;

            //     }else{
            //         ispkr=false;
            //     }
            // });







        })
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.studentlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/student/paidpackages.blade.php ENDPATH**/ ?>