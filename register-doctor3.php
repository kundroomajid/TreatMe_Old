<?php
include("header.php");
include("config.php");
include("session.php");
$_SESSION['msg'] = ' ';
?>

<main>
	<link rel="stylesheet" href="./css/tagsinput.css">
	<script type="text/javascript" src="./js/tagsinput.js"></script>

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
						<h3>Please Enter Your Professional Details</h3>
					</div>
					<br />

					<form method="POST" action="" id="registerDoctor3">
						<div class="box_form">
							<div class="form-group">
								<label>Specializations</label>
								<input type="text" name="specialization" class="form-control" placeholder="What is Your specialization"required />
							</div>
							<div class="form-group">
								<label>Degree</label>
								<input type="text" name="degree" class="form-control" id="degree" placeholder="Degrees" required/>
							</div>
							<div class="form-group">
								<label>Institution</label>
								<input type="text" name="institution" class="form-control" placeholder="Colleage or Institution" required/>
							</div>
							<div class="form-group">
								<label>Experience</label>
								<input type="number" name="experience" class="form-control" placeholder="Years Of Experience" required/>
							</div>

							<div class="form-group">
								<label>Registration_no</label>
								<input type="text" name="registration_no" class="form-control" placeholder="Enter Your registration_no Number" required/>
							</div>
							<div class="form-group">
								<label>Registration Year</label>
								<input type="number" name="registration_year" class="form-control" placeholder="Enter Year of registration." required/>
							</div>
							<div class="form-group">
								<label>Registration Council</label>
								<input type="text" name="registration_council" class="form-control" placeholder="Enter registration Council." required/>
							</div>

							<div class="form-group">
								<label>Clinic Name</label>
								<input type="text" name="clinic" class="form-control" placeholder="Enter Name of clinic "required />
							</div>
							<div class="form-group">
								<label>Address of clinic</label>
								<input type="text" name="address" class="form-control" placeholder="Enter the address of clinic"required />
							</div>
							<div class="form-group">
								<label>Consultation  Fee</label>
								<input type="number_format" name="fee" class="form-control" placeholder="What is  Your Consultation fee? " required/>
							</div>
							<div class="form-group">
								<label>Consultation Validity(In Days)</label>
								<input type="number" name="c_validity" class="form-control" placeholder="Consultation Valid for days"required />
							</div>
							<div class="form-group">

								Morning Shift Start Time
								<input type="time" name="morning_start_time" id ="mst" required/>
							</div>

							<div class="form-group">
								Morning Shift End Time
								<input type="time" name="morning_end_time" id ="met" required/>
							</div>
							<div class="form-group">
								Evening Shift Start Time
								<input type="time" name="evening_start_time" id ="est" required />
							</div>

							<div class="form-group">
								Evening Shift End Time
								<input type="time" name="evening_end_time" id ="eet" required/>
							</div>


							<p class="text-center add_top_30"><input type="submit" class="btn_1" value="Submit" /></p>
							<div class="text-center"><small></small></div>
					</form>
				</div>

			</div>
			<!-- /col -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
	</div>
	<!--jquery validator-->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
 <script src="./js/formvalidator.js"></script>


<!--validator ends-->
	<!-- /hero_register -->
</main>
<!-- /main -->

<?php
include("footer.php");

$doc_email = mysqli_real_escape_string($conn,$_GET['email']);
$sql = "SELECT user_id FROM tb_user WHERE user_email = '$doc_email'";

 $result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$doc_id = $row['user_id'];
if((isset($_POST['specialization'])) & (isset($_POST['morning_start_time']))& (isset($_POST['evening_start_time'])))
{
            // Verify data
  	$specialization = mysqli_real_escape_string($conn,$_POST['specialization']);
	$degree = mysqli_real_escape_string($conn,$_POST['degree']);
	$institution = mysqli_real_escape_string($conn,$_POST['institution']);
	$experience = mysqli_real_escape_string($conn,$_POST['experience']);
	$registration_no = mysqli_real_escape_string($conn,$_POST['registration_no']);
	$registration_year= mysqli_real_escape_string($conn,$_POST['registration_year']);
	$registration_council = mysqli_real_escape_string($conn,$_POST['registration_council']);
	$clinic = mysqli_real_escape_string($conn,$_POST['clinic']);
	$address = mysqli_real_escape_string($conn,$_POST['address']);
	$fee = mysqli_real_escape_string($conn,$_POST['fee']);
	$validity = mysqli_real_escape_string($conn,$_POST['c_validity']);

    $morning_start_time = (new DateTime($_POST['morning_start_time']))->format("H:i");
    $morning_end_time = (new DateTime($_POST['morning_end_time']))->format("H:i");
    $evening_start_time = (new DateTime($_POST['evening_start_time']))->format("H:i");
    $evening_end_time = (new DateTime($_POST['evening_end_time']))->format("H:i");

	$sql ="INSERT into tb_doctor (doc_id,specialization,registration_council,registration_no,registration_year,morning_start_time,morning_end_time,evening_start_time,evening_end_time,experience,clinic_name,clinic_address,fee,c_validity) values('$doc_id','$specialization','$registration_council','$registration_no','$registration_year','$morning_start_time','$morning_end_time','$evening_start_time','$evening_end_time',$experience,'$clinic','$address',$fee,$validity)";
	$sql2 = "INSERT into tb_qualifications(doct_id,degree,institute) values('$doc_id','$degree','$institution')";
	echo($sql);
	echo($sql2);

	if(mysqli_query($conn, $sql) && mysqli_query($conn, $sql2))
	{
		$msg = '<div class="alert alert-success alert-dismissible">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    	<strong>Success!</strong> Details Saved Sucessfully
  	</div>';
		echo '<script type="text/javascript">
//		alert("Details Saved Sucessfully")
		window.location = "./upload_photo.php?email='.$doc_email.'";
		</script> ';
	}
	else
	{
    	$msg = '<div class="alert alert-success alert-dismissible">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    	<strong>Error!</strong> Error in saving details
  		</div>';
		echo '<script type="text/javascript">
//		alert("query failed".mysqli_error($conn).);
		window.location = "./register-doctor3.php?email='.$doc_email.'";
		</script> ';
		mysqli_close($conn);
	}

}
else
{
	$msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Alert!</strong> Error Please Fill the Registration Form
  </div>';
	echo '<script language="javascript">';
//	echo 'alert("Error Please Fill the Registration Form")';
	echo '</script>';
}


$_SESSION['msg']  = $msg;
?>
</body>

</html>
