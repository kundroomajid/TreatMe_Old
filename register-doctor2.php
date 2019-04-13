<?php

include("header.php");
include("config.php");
include("session.php");
$doc_email = mysqli_real_escape_string($conn,$_GET['email']);
$msg = $_SESSION['msg'];


//echo $doc_email;

$_SESSION['email'] = $doc_email;
if((isset($_POST['name']))&isset($_GET['email'])){
	// Verify data

	$doc_name = mysqli_real_escape_string($conn,$_POST['name']);
	$phone_no = mysqli_real_escape_string($conn,$_POST['phone_no']);
	$gender = mysqli_real_escape_string($conn,$_POST['gender']);
	$dob = mysqli_real_escape_string($conn,$_POST['dob']);
	$district = mysqli_real_escape_string($conn,$_POST['district']);


	$sql = "UPDATE tb_user SET user_name= '$doc_name',user_phone= '$phone_no', dob = '$dob',gender = '$gender',district = '$district' WHERE user_email='$doc_email'";



	if(mysqli_query($conn, $sql)){
		$msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Details Saved Sucessfully Continue
  </div>';
		echo '<script type="text/javascript">
//		alert("Details Saved Sucessfully")
		window.location = "./register-doctor3.php?email='.$doc_email.'";
		</script> ';
	} else {
		$msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> Some Error Occured
  </div>';
	}
	$_SESSION['msg'] = $msg;
	mysqli_close($conn);



}


?>

<main>
	<div id="hero_register">
		<div class="container margin_120_95">
			<div class="row">
				<div class="col-lg-6">
					<h1>It's time to find you!</h1>
					<p class="lead"></p>
					<div class="box_feat_2">
						<i class="pe-7s-map-2"></i>
						<h3>Effortless Practice Management</h3>
						<p> Get hold of the best practice management at an amazingly affordable price. Simpler, Smarter, Secure.</p>
					</div>
					<div class="box_feat_2">
						<i class="pe-7s-date"></i>
						<h3>Grow your Practice</h3>
						<p> Take your practice to new heights where you don't just get new patients but also enhance your credibility. </p>
					</div>
					<div class="box_feat_2">
						<i class="pe-7s-phone"></i>
						<h3>Connect Globally</h3>
						<p> Reach out to thousands of patients across the globe using smart practice techniques on your phone. Talk to your patients through various channels and widen your accessibility. </p>
					</div>
				</div>
				<!-- /col -->

				<div class="col-lg-5 ml-auto">
					<br>
					<div class="box_feat_2">
						<div id="info" class="clearfix">  <?= "$msg";?> </div>
						<h3>Please Enter Your Personal Details</h3>
						<p>These Details will be kept Private. </p>
					</div>
					<br/>

					<form action="" method="POST">
						<div class="box_form">
							<div class="form-group">
								<label>Name</label>
								<input type="name" name ="name"class="form-control" placeholder="Enter Your Name" />
							</div>
							<div class="form-group">
								<label>PhoneNo</label>
								<input type="phone_no" name ="phone_no" class="form-control" id="phone_no" placeholder="Phone No" />
							</div>
							<p>
								<label>Gender</label>
								<input type = "radio"
								name = "gender"
								id = "male"
								value = "Male" />
								<label for = "male">Male</label>
								<input type = "radio"
								name = "gender"
								id = "female"
								value = "Female" />
								<label for = "female">Female</label>
								<input type = "radio"
								name = "gender"
								id = "other"
								value = "Other" />
								<label for = "other">Other</label>
							</p>
							<div class="form-group">
								<label>Date Of Birth</label>
								<input type="date" name ="dob" class="form-control"/>
							</div>
							
							<label>Select District</label>
							<select id = "district" class="form-control" name ="district">
								<option value = "Anantnag">Anantnag</option>
								<option value = "Bandipora">Bandipora</option>
								<option value = "Baramulla">Baramulla</option>
								<option value = "Budgam">Budgam</option>
								<option value = "Ganderbal">Ganderbal</option>
								<option value = "Kulgam">Kulgam</option>
								<option value = "Kupwara">Kupwara</option>
								<option value = "Pulwama">Pulwama</option>
								<option value = "Shopain">Shopain</option>
								<option value = "Srinagar">Srinagar</option>
								<option value = "Doda">Doda</option>
								<option value = "Jammu">Jammu</option>
								<option value = "Kathua">Kathua</option>
								<option value = "Kishtwar">Kishtwar</option>
								<option value = "Poonch">Poonch</option>
								<option value = "Rajouri">Rajouri</option>
								<option value = "Reasi">Reasi</option>
								<option value = "Ramban">Ramban</option>
								<option value = "Samba">Samba</option>
								<option value = "Udhampur">Udhampur</option>
								<option value = "Kargil">Kargil</option>
								<option value = "Leh">Leh</option>
							</select>


							<p class="text-center add_top_30"><input type="submit" class="btn_1" value="Submit" /></p>
							<div class="text-center"><small></small></div>
						</form>
					</div>
					<!-- /box_form -->
				</div>
				<!-- /col -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /hero_register -->
</main>
<!-- /main -->


</body>
</html>
<?php include("footer.php")?>
