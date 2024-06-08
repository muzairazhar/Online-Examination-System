

<?php $__env->startSection('space-works'); ?>


<?php if(session('success')): ?>

<div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
    <strong>Success</strong>  <?php echo e(session('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<h2>Payment Details</h2>

<table class="table table-hover  mt-5">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Exam Name</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($paymentdetails)>0): ?>
        <?php
        $x=1;
    ?>
        <?php $__currentLoopData = $paymentdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($x++); ?></td>
            <td><?php echo e($payment->username[0]['name']); ?> </td>
            <td><?php echo e($payment->examname[0]['exam_name']); ?></td>
            <td>

                <a href="" class="btn btn-danger showdetails" data-bs-toggle="modal" data-details="<?php echo e($payment->payment_details); ?>" data-bs-target="#shoedetails">Details</a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <td colspan="4">No Payments Found!</td>
        <?php endif; ?>
    </tbody>
</table>


<div class="modal fade" id="shoedetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="paymentdetailss container" style="overflow:auto">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            

        </div>
     
    </div>
</div>


<script>
    $(document).ready(function(){
        $(".showdetails").click(function(){
            var details=$(this).attr('data-details');
           details= JSON.parse(details);
           console.log( details)
           var html='';

      
           html+=`
           <p><b>id:-</b>`+details['id']+`</p>           
           <p><b>Student name: </b>`+details['metadata']['user_name']+`</p>
           <p><b>Student emal: </b>`+details['metadata']['user_email']+`</p>
           <p><b>amount:-</b>`+details['amount']+`</p>           
           <p><b>amount refunded:-</b>`+details['amount_refunded']+`</p>           
           <p><b>receipt url:-</b>`+details['receipt_url']+`</p>           
           <p><b>Description:-</b>`+details['description']+`</p>           
           `;
           
          
    
           $(".paymentdetailss").html(html);
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.admin-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/admin/paymentdetails.blade.php ENDPATH**/ ?>