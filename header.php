	<?php
include('session.php');?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="Find trusted medical advice from Kashmir's top doctors" />
		<meta name="keywords" content="treatme,treatme.co.in,kashmir,appointment booking, doctor,rating,top doctors in j&k,top doctors in Kashmir"/>
		<meta name="author" content="Kash Dev Squad" />
		<title> TreatMe | Appointments | Reviews Find trusted medical advice from Kashmir's top doctors</title>

		<!-- Favicons-->
		<link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon" sizes="16x16" />
		<link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon" sizes="32x32" />
		<link rel="shortcut icon" href="./img/favicon.png" type="image/x-icon" sizes="64x64" />


		<!-- BASE CSS -->
		<link href="./css/bootstrap.min.css" rel="stylesheet" />
		<link href="./css/style.css" rel="stylesheet" />
		<link href="./css/menu.css" rel="stylesheet" />
		<link href="./css/vendors.css" rel="stylesheet" />
		<link href="./css/icon_fonts/css/all_icons_min.css" rel="stylesheet" />
		<link href="./css/ratecss.css" rel="stylesheet">

		<!-- YOUR CUSTOM CSS -->

		<!-- COMMON SCRIPTS -->

		<script src="./js/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

		<script src="./js/common_scripts.min.js"></script>
		<script src="./js/functions.js"></script>
		<script src="./js/app.js"></script>



		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>

		<div class="layer"></div>
		<!-- Mobile menu overlay mask -->

		<div id="preloader">
			<div data-loader="circle-side"></div>
		</div>
		<!-- End Preload -->

		<header class="header_sticky">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-6">
						<div id="logo_home">
							<a href="./index.php">
								<img border="0" alt="TreatMe.co.in" src="./img/logo.png" width="80%" height="80%">
							</a>
						</div>
					</div>
					<nav class="col-lg-9 col-6">
						<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="#0"><span>Menu mobile</span></a>
						<?php
							
								if(isset($_SESSION['login_user']))
								{
									
                                  $username = ($_SESSION['login_user']);
									echo '<ul id="top_access" style="height:45px;width:45px;">';
							
				
								
									echo "<li id='user'><a href='welcome.php'> <figure> $imagepic</figure>$user</a></li>";
								}
								else
								{
									echo '<ul id="top_access">';
									echo '<li><a href="./login.php" onclick="restack(currentStack)" title="Login"><i class="pe-7s-user"></i></a></li>';
									echo '<li><a href="./register.php" onclick="restack(currentStack)" title="Register Here"><i class="pe-7s-add-user"></i></a></li>';

								}
							?>


						</ul>
						<div class="main-menu">
							<ul>
								<li class="menu">
									<a href="index.php" class="show-submenu">Home<i class="menu"></i></a>

								</li>
								<li class="menu">
									<a href="./list.php" class="show-submenu">Find a Doctor<i class="menu"></i></a>

								</li>
								<li class="menu">
									<a href="./list.php?radio_search=clinic" class="show-submenu">Find a Clinic<i class="menu"></i></a>

								</li>

								<li class="menu">
									<a href="./about.php" class="show-submenu">About<i class="menu"></i></a>

								</li>
								<?php
								if(isset($_SESSION['login_user']))
								{
									echo '<li class="menu">
										<a href="./logout.php" class="show-submenu">Logout<i class="menu"></i></a>

									</li>';
								}
                                  ?>

							</ul>
						</div>
						<!-- /main-menu -->
					</nav>
				</div>
			</div>
			<!-- /container -->

		</header>

		<!-- /header -->


		<!-- Back to top button -->
		<div id="toTop"></div>