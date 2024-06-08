<!doctype html>
<html lang="en">
  <head>
  	<title>OES </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="<?php echo e(asset('js/multiselect-dropdown.js')); ?>"></script>
        
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1>
          <a href="/admin/dashboard" class="logo"  style="text-decoration: none">Hi:<?php echo e(Auth::user()->name); ?>

        </a>
      </h1>

        <ul class="list-unstyled components mb-5">
          
          <li class="active" style="text-decoration: none">
            <a href="/admin/students"   style="text-decoration: none" >
              <span class="fa fa-dashboard mr-3"></span>Dashboard</a>
          </li>


          <li class="active" style="text-decoration: none">
            <a href="<?php echo e(route('paidexams')); ?>"   style="text-decoration: none" >
              <span class="fa fa-tasks mr-3"></span>Paid Exams</a>
          </li>

          <li class="active" style="text-decoration: none">
            <a href="<?php echo e(route('paidpackage')); ?>"   style="text-decoration: none" >
              <span class="fa fa-gift mr-3"></span>Paid Package</a>
          </li>

          <li class="active" style="text-decoration: none">
            <a href="<?php echo e(route('resultdashboard')); ?>"   style="text-decoration: none" >
              <span class="fa fa-list-alt mr-3"></span>Results</a>
          </li>
          

          <li>
              <a href="/logout"  style="text-decoration: none"><span class="fa fa-sign-out mr-3" ></span>Logout</a>
          </li>
   
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
<?php echo $__env->yieldContent('space-works'); ?>
		</div>

    

    <script src="<?php echo e(asset('js/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html><?php /**PATH D:\all-laravel-works\Online-Examination-System\resources\views/layout/studentlayout.blade.php ENDPATH**/ ?>