<?php
include("header.php");

 ?>

	<main>
		<div class="hero_home version_1">
			<div class="content">
			 <font size="10">Healthcare </font>
				<p>Find trusted medical advice from Kashmir's top doctors<br>

				</p>

			<form method="GET" action="list.php"  id = "search"/>
					<div id="custom-search-input">
						<div class="input-group">
							<input type="text" id = "search" name="q" class=" search-query" placeholder="Search doctors, clinics, hospitals etc." />
            	<input type="submit" class="btn_search" value="Search" />
						</div>
						<ul>
							<li>
								<input type="radio" id="all" name="radio_search" value="all" checked="" />
								<label for="all">All</label>
							</li>
							<li>
								<input type="radio" id="doctor" name="radio_search" value="doctor" />
								<label for="doctor">Doctor</label>
							</li>
							<li>
								<input type="radio" id="clinic" name="radio_search" value="clinic" />
								<label for="clinic">Clinic</label>
							</li>
						</ul>
					</div>
				</form>
			</div>
		</div>
		<!-- /Hero -->

		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Discover the <strong>online</strong> appointment!</h2>

			</div>
			<div class="row add_bottom_30">
				<div class="col-lg-4">
					<div class="box_feat" id="icon_1">
						<span></span>
						<h3>Find a Doctor</h3>

					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_2">
						<span></span>
						<h3>View profile</h3>

					</div>
				</div>
				<div class="col-lg-4">
					<div class="box_feat" id="icon_3">
						<h3>Book a visit</h3>

					</div>
				</div>
			</div>
			<!-- /row -->
			<p class="text-center"><a href="./list.php" class="btn_1 medium">Find Doctor</a></p>

		</div>
		<!-- /container -->





		<div class="bg_color_1">
			<div class="container margin_120_95">
				<div class="main_title">
					<h2>Most Viewed doctors</h2>
					<!--<p>Usu habeo equidem sanctus no. Suas summo id sed, erat erant oporteat cu pri.</p>-->
				</div>
				<div id="reccomended" class="owl-carousel owl-theme">
					<?php 
					$query="SELECT * FROM vw_doctor LIMIT 10";
					$result=mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error());
					$count = mysqli_num_rows($result);
									
            while ($cdrow=mysqli_fetch_array($result)) {
                $user_name=$cdrow["user_name"];
                $doc_id=$cdrow["doc_id"];
				$specialization = $cdrow["specialization"];               
				$image = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow["photo"])."' />";
					?>
					<div class="item">
						<a href="./detail-page.php?doc_id =<?="$doc_id";?>">
							<div class="views"><i class="icon-eye-7"></i>98</div>
							<div class="title">
								<h4><?= "$user_name";?>  <em><?= "$specialization";?></em></h4>
							</div>
							<img src="" alt="" />
							<?= "$image";?>
						</a>
					</div>
					<?php }?>
				</div>
				<!-- /carousel -->
			</div>
			<!-- /container -->
		</div>
		<!-- /white_bg -->

		<div class="container margin_120_95">
			<div class="main_title">
				<h2>Find your doctor or clinic</h2>
				<!--<p>Nec graeci sadipscing disputationi ne, mea ea nonumes percipitur. Nonumy ponderum oporteat cu mel, pro movet cetero at.</p>-->
			</div>
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-md-6">
					<div class="list_home">
						<div class="list_title">
							<i class="icon_pin_alt"></i>
							<h3>Search by District</h3>
						</div>
						<ul>
							<li><a href="#0"><strong>01</strong>Anantnag</a></li>
							<li><a href="#0"><strong>02</strong>Baramulla</a></li>
							<li><a href="#0"><strong>03</strong>Bandipora</a></li>
							<li><a href="#0"><strong>04</strong>Budgam</a></li>
							<li><a href="#0"><strong>05</strong>Ganderbal</a></li>
							<li><a href="#0"><strong>06</strong>Kulgam</a></li>
							<li><a href="#0"><strong>07</strong>Kupwara</a></li>
							<li><a href="#0"><strong>08</strong>Pulwama</a></li>
							<li><a href="#0"><strong>09</strong>Shopain</a></li>
							<li><a href="#0"><strong>10</strong>Srinagar</a></li>
							<li><a href="#0">More...</a></li>
						</ul>
					</div>
				</div>
				<div class="col-xl-4 col-lg-5 col-md-6">
					<div class="list_home">
						<div class="list_title">
							<i class="icon_archive_alt"></i>
							<h3>Search by type</h3>
						</div>
						<ul>
							<li><a href="#0"><strong>01</strong>Allergist</a></li>
							<li><a href="#0"><strong>02</strong>Cardiologist</a></li>
							<li><a href="#0"><strong>03</strong>Chiropractor</a></li>
							<li><a href="#0"><strong>04</strong>Dentist</a></li>
							<li><a href="#0"><strong>05</strong>Dermatologist</a></li>
							<li><a href="#0"><strong>06</strong>Gastroenterologist</a></li>
							<li><a href="#0"><strong>07</strong>Ophthalmologist</a></li>
							<li><a href="#0"><strong>08</strong>Optometrist</a></li>
							<li><a href="#0"><strong>09</strong>Pediatrician</a></li>
							<li><a href="#0">More....</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->

		<div id="app_section">
			<div class="container">
				<div class="row justify-content-around">
					<div class="col-md-5">
						<p><img src="./img/app_img.svg" alt="" class="img-fluid" width="500" height="433" /></p>
					</div>
					<div class="col-md-6">

						<h3>Download <strong> Healthcare app</strong> </h3>


						<p class="lead">

Like millions of Healthcare users, book your appointments anytime, anywhere.
  </p>
						<div class="app_buttons wow" data-wow-offset="100">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 43.1 85.9" style="enable-background:new 0 0 43.1 85.9;" xml:space="preserve">
							<path stroke-linecap="round" stroke-linejoin="round" class="st0 draw-arrow" d="M11.3,2.5c-5.8,5-8.7,12.7-9,20.3s2,15.1,5.3,22c6.7,14,18,25.8,31.7,33.1"></path>
							<path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-1" d="M40.6,78.1C39,71.3,37.2,64.6,35.2,58"></path>
							<path stroke-linecap="round" stroke-linejoin="round" class="draw-arrow tail-2" d="M39.8,78.5c-7.2,1.7-14.3,3.3-21.5,4.9"></path>
						</svg>
							<a href="#0" class="fadeIn"><img src="./img/apple_app.png" alt="" width="150" height="50" data-retina="true" /></a>
							<a href="#0" class="fadeIn"><img src="./img/google_play_app.png" alt="" width="150" height="50" data-retina="true" /></a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /app_section -->
	</main>
	<!-- /main content -->
<?php include("footer.php"); ?>
</body>

</html>
