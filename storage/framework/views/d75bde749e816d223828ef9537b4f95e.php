<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>TELLO</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/img/CLSULogo.png')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/all.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fontawesome/css/fontawesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/feathericon.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fullcalendar/fullcalendar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<div class="main-wrapper">
		<div class="header">
			<div class="header-left">
				<a href="<?php echo e(route('admin.home')); ?>" class="logo"> <img src="<?php echo e(asset('assets/img/CLSULogo.png')); ?>" width="50" height="70" alt="logo"> <span class="logoclass">HOTEL</span> </a>
				<a href="<?php echo e(route('admin.home')); ?>" class="logo logo-small"> <img src="<?php echo e(asset('assets/img/CLSULogo.png')); ?>" alt="Logo" width="30" height="30"> </a>
			</div>
			<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
			<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
			<ul class="nav user-menu">
				<li class="nav-item dropdown has-arrow">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="<?php echo e(asset('assets/img/CLSULogo.png')); ?>" width="31" alt="Soeng Souy"></span> </a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm"> <img src="assets/img/CLSULogo.png" alt="User Image" class="avatar-img rounded-circle"> </div>
							<div class="user-text">
								<h6>Arjay Hagid</h6>
								<p class="text-muted mb-0">Administrator</p>
							</div>
						</div>
                        <a class="dropdown-item" href="profile.html">My Profile</a>
                        <a class="dropdown-item" href="settings.html">Account Settings</a>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> <span><?php echo e(__('Logout')); ?></span></a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
				</li>
			</ul>
		</div>
		<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="active"> <a href="<?php echo e(route('housekeeper.home')); ?>"><i class="fas fa-home"></i> <span>Dashboard</span></a> </li>
						<li class="list-divider"></li>
						<li> <a href="<?php echo e(route('housekeeper.rooms')); ?>"><i class="fas fa-key"></i> <span>Room</span></a> </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="page-wrapper">
			<?php echo $__env->yieldContent('content'); ?>
		</div>
	</div>
    <script src="<?php echo e(asset('assets/js/jquery-3.5.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/slimscroll/jquery.slimscroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap-datetimepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/fullcalendar/fullcalendar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/fullcalendar/jquery.fullcalendar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
</body>

<script>
    $(document).ready(function() {
    console.log("Document ready");
    $('#toggle_btn').click(function() {
        console.log("Toggle button clicked");
        $('#sidebar').toggleClass('active');
    });
});

</script>

</html>
<?php /**PATH C:\xampp\htdocs\HMS\resources\views/Housekeeper/layout.blade.php ENDPATH**/ ?>