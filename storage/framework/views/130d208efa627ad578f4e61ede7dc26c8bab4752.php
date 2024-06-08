<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

    <form action="" id="check">
        <?php echo csrf_field(); ?>
        <button type="submit">Submit</button>    
    </form>   

    <script>
      $(document).ready(function() {
    $("#check").submit(function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        $.ajax({
            type: "GET",
            url: "<?php echo e(url('/dashboard')); ?>",
            success: function(data) {
                console.log('Server Response:', data); // Log the response
                
                // Add your logic to handle the response here
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr, status, error);
                alert('An error occurred while processing your request.');
            }
        });
    });
});

    </script>

</body>
</html>
<?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/test.blade.php ENDPATH**/ ?>