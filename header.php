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
			<title> Healthcare- Reviews  | Find trusted medical advice from Kashmir's top doctors</title>

			<!-- Favicons-->
			<link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon" />
			<link rel="apple-touch-icon" type="image/x-icon" href="./img/apple-touch-icon-57x57-precomposed.png" />
			<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="./img/apple-touch-icon-72x72-precomposed.png" />
			<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="./img/apple-touch-icon-114x114-precomposed.png" />
			<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="./img/apple-touch-icon-144x144-precomposed.png" />

			<!-- BASE CSS -->
			<link href="./css/bootstrap.min.css" rel="stylesheet" />
			<link href="./css/style.css" rel="stylesheet" />
			<link href="./css/menu.css" rel="stylesheet" />
			<link href="./css/vendors.css" rel="stylesheet" />
			<link href="./css/icon_fonts/css/all_icons_min.css" rel="stylesheet" />

			<!-- YOUR CUSTOM CSS -->
			
	<!--
			<link rel="stylesheet" type="text/css" href="./css/custom.css">

	-->

			<!-- COMMON SCRIPTS -->
			<script src="./cdn-cgi/scripts/84a23a00/cloudflare-static/email-decode.min.js"></script><script src="./js/jquery-2.2.4.min.js"></script>
			<script src="./js/common_scripts.min.js"></script>
			<script src="./js/functions.js"></script>
			

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
								<h1><a href="index.php" title="Healthcare"> Healthcare</a></h1>
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
//									echo "<li><a href='logout.php' >&nbsp;&nbsp;&nbsp; Logout</a></li>";
									echo "<li class='show-submenu'><a href='logout.php' tabindex='0'  class='show-submenu'><span class='glyphicon glyphicon-user'></span>Logout</a></li>";
//									echo "<a href='logout.php'><img src='img/logout.png' alt='Logout' /> </a>";
//									echo '<li><a href="./logout.php" onclick="restack(currentStack)" title="Logout"><i class="icon-logout"></i></a></li>';
                                  
									  

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
										<a href="./list.php" class="show-submenu">Find a Hospital<i class="menu"></i></a>

									</li>

									<li class="menu">
										<a href="#0" class="show-submenu">Appoinments<i class="menu"></i></a>

									</li>

									<li class="menu">
										<a href="#0" class="show-submenu">About<i class="menu"></i></a>

									</li>
								</ul>
							</div>
							<!-- /main-menu -->
						</nav>
					</div>
				</div>
				<!-- /container -->
				
			</header>
<!--			<div id="info" class="clearfix">  <?= "$error";?> </div>-->
			
			<!-- /header -->
			
			
			<!-- Back to top button -->
			<div id="toTop"></div>
