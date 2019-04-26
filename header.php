	<?php
include('session.php');?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
			<meta name="description" content="Find trusted medical advice from Kashmir's top doctors" />
			<meta name="author" content="" />
			<title> TreatMe- Reviews  | Find trusted medical advice from Kashmir's top doctors</title>

			<!-- Favicons-->
			<link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon" sizes="16x16" />
			<link rel="shortcut icon" href="./img/favicon-32x32.png" type="image/x-icon" sizes="32x32" />

			<!-- iOS 7 or prior (legacy) -->
			<link rel="apple-touch-icon" sizes="144x144" href="./img/apple-touch-icon-144x144.png">
			<link rel="apple-touch-icon" sizes="114x114" href="./img/apple-touch-icon-114x114.png">
			<link rel="apple-touch-icon" sizes="72x72" href="./img/apple-touch-icon-72x72.png"> 
			<link rel="apple-touch-icon" sizes="57x57" href="./img/apple-touch-icon-57x57.png">

   
			<!-- iOS 8 and later -->
			<link rel="apple-touch-icon" sizes="180x180" href="./img/apple-touch-icon-180x180.png">
			<link rel="apple-touch-icon" sizes="152x152" href="./img/apple-touch-icon-152x152.png">
			<link rel="apple-touch-icon" sizes="120x120" href="./img/apple-touch-icon-120x120.png">
			<link rel="apple-touch-icon" sizes="76x76" href="./img/apple-touch-icon-76x76.png">
			<link rel="apple-touch-icon" sizes="60x60" href="./img/apple-touch-icon-60x60.png">

			<!-- launcher (Android/Chrome) -->
			<link rel="manifest" href="./img/manifest.json">
			
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
			<script src="./js/common_scripts.min.js"></script>
			<script src="./js/functions.js"></script>
			<script src="./js/app.js"></script>
			


		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

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
								<h1><a href="index.php" title="TreatMe"> TreatMe</a></h1>
							</div>
						</div>
						<nav class="col-lg-9 col-6">
					<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="#0"><span>Menu mobile</span></a>
							<ul id="top_access">
								<li id="user">
										<?php
								if(isset($_SESSION['login_user']))
								{
									echo "<a href='welcome.php'> <figure> $imagepic </figure> <sub>$user</sub> </a>";
									$username = ($_SESSION['login_user']);
									echo "<li class='show-submenu'><a href='logout.php' tabindex='0'  class='show-submenu'><span class='glyphicon glyphicon-user'></span>Logout</a></li>";



								}
								else
								{
									echo '<li><a href="./login.php" onclick="restack(currentStack)" title="Login"><i class="pe-7s-user"></i></a></li>';
									echo '<li><a href="./register.php" onclick="restack(currentStack)" title="Register Here"><i class="pe-7s-add-user"></i></a></li>';

								}
							?>
								</li>

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
