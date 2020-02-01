<?php
include_once('schedule_controller.php');
$bookerror = $_SESSION['var'];
$msg = " ";

$curr_date = date("Y-m-d"); // variable gets current date
$doc_id = isset($_GET['doc_id']) ? mysqli_real_escape_string($conn, $_GET['doc_id']) : null;

$pat_id = (isset($_SESSION['id']) && $_SESSION['user_type'] == 'p') ? $_SESSION['id'] : null;
$user_type = $_SESSION['user_type'];
$schedule = get_schedule($doc_id);
$schedule = ($schedule == "") ? "''" : $schedule;

if ($doc_id != null) {
	$query1 = "SELECT * FROM vw_doctor where user_id = $doc_id";
	$result1 = mysqli_query($conn, $query1) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$cdrow1 = mysqli_fetch_array($result1);

	$query2 = "SELECT * FROM tb_doctor where doc_id = $doc_id";
	$result2 = mysqli_query($conn, $query2) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$cdrow = mysqli_fetch_array($result2);

	//	queries to get number of 5,4,3,2,1, star ratiings from db
	$sql = "SELECT count(*) as total from tb_rating where doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$total = $row['total'];

	$sql = "SELECT count(*) as stars from tb_rating where rate = 5 and doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from tb_rating failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$fivestars = $row['stars'];
	$fivestars = ($total > 0) ? ($fivestars / $total) * 100 : 0;

	// get number of four stars
	$sql = "SELECT count(*) as stars from tb_rating where rate = 4 and doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$fourstars = $row['stars'];
	$fourstars = ($total > 0) ? ($fourstars / $total) * 100 : 0;

	$sql = "SELECT count(*) as stars from tb_rating where rate = 3 and doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$threestars = $row['stars'];
	$threestars = ($total > 0) ? ($threestars / $total) * 100 : 0;

	$sql = "SELECT count(*) as stars from tb_rating where rate = 2 and doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$twostars = $row['stars'];
	$twostars = ($total > 0) ? ($twostars / $total) * 100 : 0;

	$sql = "SELECT count(*) as stars from tb_rating where rate = 1 and doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$onestars = $row['stars'];
	$onestars = ($total > 0) ? ($onestars / $total) * 100 : 0;

	$sql = "SELECT count(*) as t_comments from comments where doc_id = $doc_id";
	$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	$total_comments = $row['t_comments'];

	if ($total_comments > 3)
		$comment_count = 3;
	else
		$comment_count = $total_comments;

	if ($cdrow1 != null) {
		$user_name = $cdrow1["user_name"];
		$district = $cdrow1['district'];
		$morning_start_time = (new DateTime($cdrow["morning_start_time"]))->format("h:i A");
		$morning_end_time = (new DateTime($cdrow["morning_end_time"]))->format("h:i A");
		$evening_start_time = (new DateTime($cdrow["evening_start_time"]))->format("h:i A");
		$evening_end_time = (new DateTime($cdrow["evening_end_time"]))->format("h:i A");
		$image = "<img src = 'data:image/jpeg;base64," . base64_encode($cdrow1["photo"]) . "' width='250' height='200' /><br/>";
		$specialization = $cdrow1["specialization"];
		$views = $cdrow1['views'];
		$patients = $cdrow1['patients'];
		$avg_rating = $cdrow1['avg_rating'];
		$experience = $cdrow1['experience'];
		$clinic_name = $cdrow1['clinic_name'];
		$clinic_address = $cdrow1['clinic_address'];
		$fee = $cdrow1['fee'];
		$c_validity = $cdrow1['c_validity'];
		if (strlen($specialization) > 24) {
			$spec_Array =  explode(",", $specialization);
			$spec1 = $spec_Array[0];
			$spec2 = $spec_Array[1];
		} else {
			$spec1 = $specialization;
		}

		// TO GET DATA FROM RATING
		$query = mysqli_query($conn, "SELECT * FROM tb_rating where doc_id = $doc_id");
		while ($data = mysqli_fetch_assoc($query)) {
			$rate_db[] = $data;
			$sum_rates[] = $data['rate'];
		}
		if (@count($rate_db)) {
			$rate_times = count($rate_db);
			$sum_rates = array_sum($sum_rates);
			$rate_value = $sum_rates / $rate_times;
			$rate_bg = (($rate_value) / 5) * 100;
		} else {
			$rate_times = 0;
			$rate_value = 0;
			$rate_bg = 0;
		}

		$sql = "Update tb_doctor set rated_by = $rate_times,avg_rating = $rate_value,views = $views+1 where doc_id = $doc_id";
		$res = mysqli_query($conn, $sql) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	}else{
		header("Location:list.php");	
	}
} else {
	header("Location:list.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$comment = mysqli_real_escape_string($conn, $_POST['comment']);
	$comment_query = mysqli_query($conn, "SELECT * FROM comments WHERE doc_id = $doc_id and pat_id=$pat_id");
	$comment_rows = mysqli_num_rows($comment_query);

	if ($comment_rows == 0)
		$sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
	else
		$sql = "UPDATE comments SET comment = '$comment' WHERE doc_id = $doc_id and pat_id = $pat_id";
	$sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";


	if (mysqli_query($conn, $sql)) {
		$msg = '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Comment Posted Sucessfully</div>';
		echo '<script type="text/javascript">
    //    alert("comment Sucessfully")
    </script> ';
	} else {

		$msg = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Something went Wrong
    </div>';
	}
	unset($comment);
}

if (isset($_SESSION['login_user'])) {
	$query1 = "SELECT user_name FROM tb_user where user_id = $pat_id ";
	$result1 = mysqli_query($conn, $query1) or die("Query to get data from firsttable failed: " . mysqli_error($conn));
	$cdrow1 = mysqli_fetch_array($result1);
	$pat_name = $cdrow1["user_name"];
}


?>


<?php include_once('header.php'); ?>
<main>
	<div id="breadcrumb">
		<div class="container">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Category</a></li>
				<li>Page active</li>
			</ul>
		</div>
	</div>
	<!-- /breadcrumb -->

	<div class="container margin_60">
		<div class="row">
			<aside class="col-xl-3 col-lg-4" id="sidebar">
				<div class="box_profile">
					<figure>
						<img src="http://via.placeholder.com/565x565.jpg" alt="" class="img-fluid">
					</figure>
					<!-- <small>Primary care - Internist</small> -->
					<h1><?= $user_name ?></h1>
					<span class="rating">
						<i class="icon_star voted"></i>
						<i class="icon_star voted"></i>
						<i class="icon_star voted"></i>
						<i class="icon_star voted"></i>
						<i class="icon_star"></i>
						<small>(145)</small>
						<a href="badges.html" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="img/badges/badge_1.svg" width="15" height="15" alt=""></a>
					</span>
					<ul class="statistic">
						<li><?= $views ?> Views</li>
						<li><?= $patients ?> Patients</li>
					</ul>
					<ul class="contacts">
						<li>
							<h6>Address</h6> <?= "$clinic_address $district" ?>
						</li>
						<li>
							<h6>Phone</h6><a href="tel://000434323342">+00043 4323342</a>
						</li>
					</ul>
					<!-- <div class="text-center"><a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" class="btn_1 outline" target="_blank"><i class="icon_pin"></i> View on map</a></div> -->
				</div>
			</aside>
			<!-- /asdide -->

			<div class="col-xl-9 col-lg-8">
				<form action="make_appointment.php" method="post">
					<input type="hidden" name="doc_id" value="<?= $doc_id ?>" />
					<input type="hidden" name="pat_id" value="<?= $pat_id ?>" />
					<div class="box_general_2">
						<div class="main_title_4">
							<h3><i class="icon_circle-slelected"></i>Select your date and time</h3>
						</div>

						<div class="row">
							<div class="col-lg-7">
								<div class="form-group">
									<input type="text" name="pat_name" class="form-control" placeholder="Enter Patient's name" required />
								</div>

								<div class="form-group">
									<div id="calendar">
										<input type="date" name="date" id="date" onchange="calendar_event(this,<?= $doc_id ?>)" style="display:none" />
									</div>
									<input type="hidden" id="my_hidden_input">
									<ul class="legend">
										<li><strong></strong>Available</li>
										<li><strong></strong>Not available</li>
									</ul>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="row justify-content-center">
									<div class="col-6 text-center add_top_20">
										<ul class="time_select" id="morning">
										</ul>
									</div>
									<div class="col-6 text-center add_top_20">
										<ul class="time_select" id="evening">
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="text-center"><input type="submit" class="btn_1 medium" value="Book Now" /></div>
					</div>
					<!-- /box_general -->
				</form>
				<!-- /booking_calendar -->

				<div class="tabs_styled_2">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-expanded="true">General info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">Reviews</a>
						</li>
					</ul>
					<!--/nav-tabs -->

					<div class="tab-content">
						<div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">

							<p class="lead add_bottom_30">Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p>
							<div class="indent_title_in">
								<i class="pe-7s-user"></i>
								<h3>Professional statement</h3>
								<p>Mussum ipsum cacilds, vidis litro abertis.</p>
							</div>
							<div class="wrapper_indent">
								<p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapi.</p>
								<h6>Specializations</h6>
								<div class="row">
									<div class="col-lg-6">
										<ul class="bullets">
											<li>Abdominal Radiology</li>
											<li>Addiction Psychiatry</li>
											<li>Adolescent Medicine</li>
											<li>Cardiothoracic Radiology </li>
										</ul>
									</div>
									<div class="col-lg-6">
										<ul class="bullets">
											<li>Abdominal Radiology</li>
											<li>Addiction Psychiatry</li>
											<li>Adolescent Medicine</li>
											<li>Cardiothoracic Radiology </li>
										</ul>
									</div>
								</div>
								<!-- /row-->
							</div>
							<!-- /wrapper indent -->

							<hr>

							<div class="indent_title_in">
								<i class="pe-7s-news-paper"></i>
								<h3>Education</h3>
								<p>Mussum ipsum cacilds, vidis litro abertis.</p>
							</div>
							<div class="wrapper_indent">
								<p>Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapi.</p>
								<h6>Curriculum</h6>
								<ul class="list_edu">
									<li><strong>New York Medical College</strong> - Doctor of Medicine</li>
									<li><strong>Montefiore Medical Center</strong> - Residency in Internal Medicine</li>
									<li><strong>New York Medical College</strong> - Master Internal Medicine</li>
								</ul>
							</div>
							<!--  End wrapper indent -->

							<hr>

							<div class="indent_title_in">
								<i class="pe-7s-cash"></i>
								<h3>Prices &amp; Payments</h3>
								<p>Mussum ipsum cacilds, vidis litro abertis.</p>
							</div>
							<div class="wrapper_indent">
								<p>Zril causae ancillae sit ea. Dicam veritus mediocritatem sea ex, nec id agam eius. Te pri facete latine salutandi, scripta mediocrem et sed, cum ne mundi vulputate. Ne his sint graeco detraxit, posse exerci volutpat has in.</p>
								<table class="table table-responsive table-striped">
									<thead>
										<tr>
											<th>Service - Visit</th>
											<th>Price</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>New patient visit</td>
											<td>$34</td>
										</tr>
										<tr>
											<td>General consultation</td>
											<td>$60</td>
										</tr>
										<tr>
											<td>Back Pain</td>
											<td>$40</td>
										</tr>
										<tr>
											<td>Diabetes Consultation</td>
											<td>$55</td>
										</tr>
										<tr>
											<td>Eating disorder</td>
											<td>$60</td>
										</tr>
										<tr>
											<td>Foot Pain</td>
											<td>$35</td>
										</tr>
									</tbody>
								</table>
							</div>
							<!--  End wrapper_indent -->

						</div>
						<!-- /tab_2 -->

						<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
							<div class="reviews-container">
								<div class="row">
									<div class="col-lg-3">
										<div id="review_summary">
											<strong>4.7</strong>
											<div class="rating">
												<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
											</div>
											<small>Based on 4 reviews</small>
										</div>
									</div>
									<div class="col-lg-9">
										<div class="row">
											<div class="col-lg-10 col-9">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-lg-2 col-3"><small><strong>5 stars</strong></small></div>
										</div>
										<!-- /row -->
										<div class="row">
											<div class="col-lg-10 col-9">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-lg-2 col-3"><small><strong>4 stars</strong></small></div>
										</div>
										<!-- /row -->
										<div class="row">
											<div class="col-lg-10 col-9">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-lg-2 col-3"><small><strong>3 stars</strong></small></div>
										</div>
										<!-- /row -->
										<div class="row">
											<div class="col-lg-10 col-9">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-lg-2 col-3"><small><strong>2 stars</strong></small></div>
										</div>
										<!-- /row -->
										<div class="row">
											<div class="col-lg-10 col-9">
												<div class="progress">
													<div class="progress-bar" role="progressbar" style="width: 0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-lg-2 col-3"><small><strong>1 stars</strong></small></div>
										</div>
										<!-- /row -->
									</div>
								</div>
								<!-- /row -->

								<hr>

								<div class="review-box clearfix">
									<figure class="rev-thumb"><img src="http://via.placeholder.com/150x150.jpg" alt="">
									</figure>
									<div class="rev-content">
										<div class="rating">
											<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<div class="rev-info">
											Admin – April 03, 2016:
										</div>
										<div class="rev-text">
											<p>
												Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
											</p>
										</div>
									</div>
								</div>
								<!-- End review-box -->

								<div class="review-box clearfix">
									<figure class="rev-thumb"><img src="http://via.placeholder.com/150x150.jpg" alt="">
									</figure>
									<div class="rev-content">
										<div class="rating">
											<i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<div class="rev-info">
											Ahsan – April 01, 2016
										</div>
										<div class="rev-text">
											<p>
												Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
											</p>
										</div>
									</div>
								</div>
								<!-- End review-box -->

								<div class="review-box clearfix">
									<figure class="rev-thumb"><img src="http://via.placeholder.com/150x150.jpg" alt="">
									</figure>
									<div class="rev-content">
										<div class="rating">
											<i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<div class="rev-info">
											Sara – March 31, 2016
										</div>
										<div class="rev-text">
											<p>
												Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis
											</p>
										</div>
									</div>
								</div>
								<!-- End review-box -->
							</div>
							<!-- End review-container -->
						</div>
						<!-- /tab_3 -->
					</div>
					<!-- /tab-content -->
				</div>
				<!-- /tabs_styled -->
			</div>
			<!-- /col -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</main>
<!-- /main -->

<!-- COMMON SCRIPTS -->
<!-- <script src="js/jquery-2.2.4.min.js"></script> 
<script src="js/common_scripts.min.js"></script>
<script src="js/functions.js"></script> -->

<!-- SPECIFIC SCRIPTS -->
<script src="js/bootstrap-datepicker.js"></script>
<script>
	$('#calendar').datepicker({
		todayHighlight: true,
		weekStart: 1,
		format: "yyyy-mm-dd",
		startDate: new Date()
		// datesDisabled: ["2017/10/20", "2017/11/21", "2017/12/21", "2018/01/21", "2018/02/21", "2018/03/21"],
	});
	schedule = <?= $schedule ?>;
	console.log("Schedule: ");
	console.log(schedule);
	window.onload = function() {
		calendar = document.getElementById('date');
		d = new Date();
		month = d.getMonth() + 1;
		cdate = d.getDate() + 1;
		month = (month < 10) ? ("0" + month) : month;
		cdate = (cdate < 10) ? ("0" + cdate) : cdate;
		dateString = d.getFullYear() + "-" + month + "-" + cdate;
		calendar.min = dateString;
		blockSize = 30;

	}

	function calendar_event(calendar, doc_id) {
		$.ajax({
			url: 'schedule_controller.php',
			data: {
				'action': 'get_booking_details',
				'doc_id': doc_id,
				'date': calendar.value
			},
			success: function(data) {
				console.log(data);
				booking_details = JSON.parse(data);
				console.log(booking_details);
				d = new Date(calendar.value);
				weekday = d.getDay();

				current_schedule = schedule[weekday];
				mstart = current_schedule.morning_start;
				mend = current_schedule.morning_end;
				estart = current_schedule.evening_start;
				eend = current_schedule.evening_end;
				num_patients = current_schedule.num_patients;

				dt = new Date();

				mstart = dt.setHours(mstart.substr(0, 2), mstart.substr(3, 2), 0);
				mend = dt.setHours(mend.substr(0, 2), mend.substr(3, 2), 0);
				mtime = (mend - mstart) / 60000;

				estart = dt.setHours(estart.substr(0, 2), estart.substr(3, 2), 0);
				eend = dt.setHours(eend.substr(0, 2), eend.substr(3, 2), 0);
				etime = (eend - estart) / 60000;

				morning_slots = mtime / 30;
				evening_slots = etime / 30;


				morning = document.getElementById('morning');
				inner = '<p>Morning</p>\n';
				ms = new Date(mstart);
				for (i = 1; i <= morning_slots; i++) {
					booking_detail = booking_details.filter(booking => (booking.shift == 0 && booking.slot_no == i))[0];
					slot_count = (booking_detail == null) ? 0 : booking_detail.slot_count;
					// if(i==4)
					console.log("slot count: " + slot_count + " \t --- \t num_pat " + current_schedule.num_patients);
					disabled = (slot_count == current_schedule.num_patients) ? "disabled" : "";
					console.log("disabled: " + disabled);
					label = ("0" + ms.getHours()).slice(-2) + ":" + ("0" + ms.getMinutes()).slice(-2) + " to ";
					ms.setMinutes(ms.getMinutes() + 30);
					label = label + ("0" + ms.getHours()).slice(-2) + ":" + ("0" + ms.getMinutes()).slice(-2);
					inner = inner + "<li><input type='radio' required " + disabled + "id = 'm-" + (i + 1) + "' name='slot' value='m-" + (i + 1) + "'><label for='m-" + (i + 1) + "'>" + label + "</label></li>";
				}
				morning.innerHTML = inner;

				evening = document.getElementById('evening');
				es = new Date(estart);
				inner = '<p>Evening</p>\n';
				for (i = 1; i <= evening_slots; i++) {
					booking_detail = booking_details.filter(booking => (booking.shift == 1 && booking.slot_no == i))[0];
					slot_count = (booking_detail == null) ? 0 : booking_detail.slot_count;
					disabled = (slot_count == current_schedule.num_patients) ? "disabled" : "";

					// if(i==3)
					console.log("slot count: " + slot_count + " \t --- \t num_pat " + current_schedule.num_patients);

					// inner = inner + "<li> <input type='radio'" + disabled + " name='slot' value='e-" + (i + 1) + "' />" + ("0" + es.getHours()).slice(-2) + ":" + ("0" + es.getMinutes()).slice(-2) + " to ";
					// es.setMinutes(es.getMinutes() + 30);
					// inner = inner + ("0" + es.getHours()).slice(-2) + ":" + ("0" + es.getMinutes()).slice(-2) + "</li>";


					label = ("0" + es.getHours()).slice(-2) + ":" + ("0" + es.getMinutes()).slice(-2) + " to ";
					es.setMinutes(es.getMinutes() + 30);
					label = label + ("0" + es.getHours()).slice(-2) + ":" + ("0" + es.getMinutes()).slice(-2);
					inner = inner + "<li><input type='radio' required " + disabled + "id='e-" + (i + 1) + "' name='slot' value='e-" + (i + 1) + "'><label for='e-" + (i + 1) + "'>" + label + "</label></li>";
				}

				evening.innerHTML = inner;


			}
		});
	}
</script>


<?php include_once('footer.php'); ?>