
<?php $__env->startSection('space-work'); ?>
<div class="container">
    <div class="text-center">
        <h1>Thanks for submit your Exam,<?php echo e(Auth::user()->name); ?></h1>
        <p>We will review your Exam, and update you soon  by mail.</p>
        <a href="/dashboard" class="btn btn-info">Go Back</a>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout-common', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/thank-you.blade.php ENDPATH**/ ?>