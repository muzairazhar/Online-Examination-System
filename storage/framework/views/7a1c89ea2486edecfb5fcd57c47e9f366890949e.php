<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($data['title']); ?></title>
</head>
<body>
    <p>
        <b>Hii <?php echo e($data['name']); ?></b> Your Exam (<?php echo e($data['exam_name']); ?>) review passed, So now you can check your marks
    
    </p>

    <a href="<?php echo e($data['url']); ?>">Click here to go on result page</a>

    <p>Thank you</p>
</body>
</html><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/resultmail.blade.php ENDPATH**/ ?>