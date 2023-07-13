<?php 
include 'includes/conn.php';
 if(isset($_POST['username'],$_POST['password'])){
      $name=mysqli_real_escape_string($con,$_POST['username']);
$pass=mysqli_real_escape_string($con,$_POST['password']);

$cust=mysqli_query($con,"SELECT * FROM users WHERE username='$name' AND password='".md5($pass)."' AND status='1'");
$rows=mysqli_num_rows($cust);
if($rows>0){
$row=mysqli_fetch_array($cust);
$cust_id=$row['user_id'];
$level=$row['level'];
$role=$row['role'];
$employee=$row['employee'];
 $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$employee'");
  $row1 = mysqli_fetch_array($employee);
  $employee_id=$row1['employee_id'];
$_SESSION['hotelsys']=$cust_id;
$_SESSION['sysrole']=$role;
$_SESSION['emp_id']=$employee_id;
$_SESSION['hotelsyslevel']=$level;
header("Location:index.php");
}
else{
	print_r($cust);
    header("Location:login_attempt");  
}
}
    ?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Sign In - Hotel  System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->


<!-- $DEMO =========================================================================================

	Remove this section on production
-->
	<style>
		#signin-demo {
			position: fixed;
			right: 0;
			bottom: 0;
			z-index: 10000;
			background: rgba(0,0,0,.6);
			padding: 6px;
			border-radius: 3px;
		}
		#signin-demo img { cursor: pointer; height: 40px; }
		#signin-demo img:hover { opacity: .5; }
		#signin-demo div {
			color: #fff;
			font-size: 10px;
			font-weight: 600;
			padding-bottom: 6px;
		}
	</style>
<!-- / $DEMO -->

</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-dust page-signin">


	<!-- Page background -->
	<div id="page-signin-bg">
		<!-- Background overlay -->
		<div class="overlay"></div>
		<!-- Replace this with your bg image -->
             <img src="img/bg.jpeg" alt="" style="background-size:cover">
	</div>
	<!-- / Page background -->

	<!-- Container -->
            <?php 
                            if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){
                                      ?>	
	<div class="signin-container">

		<!-- Left side -->
		<div class="signin-info">
			<a href="#" class="logo">
				<img src="assets/demo/logo-big.png" alt="" style="margin-top: -5px;">&nbsp;
				Directeur de l'hôtel
			</a> <!-- / .logo -->
<!--			<div class="slogan">
				Simple. Flexible. Powerful.
			</div>  / .slogan -->
			<ul>
                          


				<li><i class="fa fa-sitemap signin-icon"></i>S'identifier</li>
				<li><i class="fa fa-file-text-o signin-icon"></i> Simple</li>
				<li><i class="fa fa-outdent signin-icon"></i>Souple</li>
				<li><i class="fa fa-heart signin-icon"></i> Puissant</li>
			</ul> <!-- / Info list -->
		</div>
		<!-- / Left side -->

		<!-- Right side -->
		<div class="signin-form">

			<!-- Form -->
                        <form action="" id="signin-form_id" method="post">
				<div class="signin-text">
					<span>Connectez-vous à votre compte</span>
				</div> <!-- / .signin-text -->
                                                  <span class="text-danger">L'identifiant ou le mot de passe est incorrect</span>
                              				<div class="form-group w-icon">
					<input type="text" name="username" id="username_id" class="form-control input-lg" placeholder="Username">
					<span class="fa fa-user signin-form-icon"></span>
				</div> <!-- / Username -->

				<div class="form-group w-icon">
					<input type="password" name="password" id="password_id" class="form-control input-lg" placeholder="password">
					<span class="fa fa-lock signin-form-icon"></span>
				</div> <!-- / Password -->
                        
				<div class="form-actions">
					<input type="submit" value="CONNEXION" class="signin-btn bg-primary">
                                </div>
                                        <div class="form-actions">
                                        <label><a class="text-primary" href="switchlanguage?lan=fr">Francais</a>  | <a class="text-primary" href="switchlanguage?lan=en">English</a></label>
              	 </div> <!-- / .form-actions -->
			</form>
			<!-- / Form -->

		</div>
		<!-- Right side -->
	</div>
                            <?php }else{?>
       <div class="signin-container">

		<!-- Left side -->
		<div class="signin-info">
			<a href="#" class="logo">
				<img src="assets/demo/logo-big.png" alt="" style="margin-top: -5px;">&nbsp;
				Hotel Manager
			</a> <!-- / .logo -->
<!--			<div class="slogan">
				Simple. Flexible. Powerful.
			</div>  / .slogan -->
			<ul>
				<li><i class="fa fa-sitemap signin-icon"></i>Login To Get Started</li>
				<li><i class="fa fa-file-text-o signin-icon"></i> Simple</li>
				<li><i class="fa fa-outdent signin-icon"></i> Flexible</li>
				<li><i class="fa fa-heart signin-icon"></i> Powerful</li>
			</ul> <!-- / Info list -->
		</div>
		<!-- / Left side -->

		<!-- Right side -->
		<div class="signin-form">

			<!-- Form -->
                        <form action="" id="signin-form_id" method="post">
				<div class="signin-text">
					<span>Sign In to your account</span>
				</div> <!-- / .signin-text -->
                                <span class="text-danger">Login Failed!! Username or Password is incorrect</span>
                              				<div class="form-group w-icon">
					<input type="text" name="username" id="username_id" class="form-control input-lg" placeholder="Username">
					<span class="fa fa-user signin-form-icon"></span>
				</div> <!-- / Username -->

				<div class="form-group w-icon">
					<input type="password" name="password" id="password_id" class="form-control input-lg" placeholder="password">
					<span class="fa fa-lock signin-form-icon"></span>
				</div> <!-- / Password -->
                                                                     
				
				<div class="form-actions">
					<input type="submit" value="SIGN IN" class="signin-btn bg-primary">
					
				</div> <!-- / .form-actions -->
		<div class="form-actions">
                                           <label><a class="text-primary" href="switchlanguage?lan=fr">Francais</a>  | <a class="text-primary" href="switchlanguage?lan=en">English</a></label>
                                </div>	
                        </form>
			<!-- / Form -->

		</div>
		<!-- Right side -->
	</div>
                            <?php }?>
	<!-- / Container -->

	<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="js/jquery-1.10.2.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="assets/javascripts/bootstrap.min.js"></script>
<script src="assets/javascripts/pixel-admin.min.js"></script>

<script type="text/javascript">
	// Resize BG
//	init.push(function () {
//		var $ph  = $('#page-signin-bg'),
//		    $img = $ph.find('> img');
//
//		$(window).on('resize', function () {
//			$img.attr('style', '');
//			if ($img.height() < $ph.height()) {
//				$img.css({
//					height: '100%',
//					width: 'auto'
//				});
//			}
//		});
//	});

		// Setup Sign In form validation
	init.push(function () {
		$("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });
		
		// Validate username
		$("#username_id").rules("add", {
			required: true,
			minlength: 3
		});

		// Validate password
		$("#password_id").rules("add", {
			required: true,
			minlength: 1
		});
	});

	// Setup Password Reset form validation
	

	window.PixelAdmin.start(init);
</script>

</body>

</html>
