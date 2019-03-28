
<?php
include("header.php");
include("config.php");
$bookerror = $_SESSION['var'];
$msg = " ";

$curr_date = date("Y-m-d"); // variable gets current date
$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;



if($doc_id!=null){
  $query1="SELECT * FROM vw_doctor where user_id = $doc_id";
  $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $cdrow1=mysqli_fetch_array($result1);

  $query2="SELECT * FROM tb_doctor where doc_id = $doc_id";
  $result2=mysqli_query($conn,$query2) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $cdrow=mysqli_fetch_array($result2);
	
//	queries to get number of 5,4,3,2,1, star ratiings from db
	$sql = "SELECT count(*) as total from tb_rating where doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $total = $row['total'];
	
  $sql = "SELECT count(*) as stars from tb_rating where rate = 5 and doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $fivestars = $row['stars'];
	$fivestars = ($fivestars / $total) *100;
	
	// get number of four stars
   $sql = "SELECT count(*) as stars from tb_rating where rate = 4 and doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $fourstars = $row['stars'];
	$fourstars = ($fourstars / $total) *100;
	
	 $sql = "SELECT count(*) as stars from tb_rating where rate = 3 and doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $threestars = $row['stars'];
	$threestars = ($threestars / $total) *100;
	
	 $sql = "SELECT count(*) as stars from tb_rating where rate = 2 and doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $twostars = $row['stars'];
	$twostars = ($twostars / $total) *100;
	
	 $sql = "SELECT count(*) as stars from tb_rating where rate = 1 and doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $onestars = $row['stars'];
	$onestars = ($onestars / $total) *100;

	
	
	
  if($cdrow1!=null){
    $user_name = $cdrow1["user_name"];
    $district = $cdrow1['district'];
    $morning_start_time = (new DateTime($cdrow["morning_start_time"]))->format("h:i A");
    $morning_end_time = (new DateTime($cdrow["morning_end_time"]))->format("h:i A");
    $evening_start_time = (new DateTime($cdrow["evening_start_time"]))->format("h:i A");
    $evening_end_time = (new DateTime($cdrow["evening_end_time"]))->format("h:i A");
    $image = "<img src = 'data:image/jpeg;base64,".base64_encode( $cdrow1["photo"])."' width='250' height='200' /><br/>";
    $specialization = $cdrow1["specialization"];
    $views = $cdrow1['views'];
    $patients = $cdrow1['patients'];
	  $avg_rating = $cdrow1['avg_rating'];
    if(strlen($specialization) > 24)
    {
      $spec_Array =  explode (",", $specialization);
      $spec1 = $spec_Array[0];
      $spec2 = $spec_Array[1];

    }
    else
    {
      $spec1 = $specialization;
    }

    // TO GET DATA FROM RATING
    $query = mysqli_query($conn,"SELECT * FROM tb_rating where doc_id = $doc_id");
    while($data = mysqli_fetch_assoc($query)){
      $rate_db[] = $data;
      $sum_rates[] = $data['rate'];

    }
    if(@count($rate_db)){
      $rate_times = count($rate_db);
      $sum_rates = array_sum($sum_rates);
      $rate_value = $sum_rates/$rate_times;
      $rate_bg = (($rate_value)/5)*100;
    }else{
      $rate_times = 0;
      $rate_value = 0;
      $rate_bg = 0;
    }

$sql = "Update tb_doctor set rated_by = $rate_times,avg_rating = $rate_value,views = $views+1 where doc_id = $doc_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  
  }
}

else die("doc id not found");
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $comment = mysqli_real_escape_string($conn,$_POST['comment']);
  $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";

  if(mysqli_query($conn, $sql)){
    $msg = '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Comment Posted Sucessfully</div>';
    echo '<script type="text/javascript">
    //    alert("comment Sucessfully")
    </script> ';
  } else {

    $msg ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Something went Wrong
    </div>';

  }

}

?>



<main>
  <div id="breadcrumb">
    <div class="container">
      <!--
      <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Category</a></li>
      <li>Page active</li>
    </ul>
  -->
</div>
</div>
<!-- /breadcrumb -->
<div class="container margin_60">

  <div class="row">
    <aside class="col-xl-4 col-lg-4" id="sidebar">
      <div class="box_general_3 booking">
        <form action ="book_appointment.php">
          <div class="title">
            <h3>Book a Visit</h3>
            <br><small><b>Morning Shift:</b> <?= $morning_start_time." to ".$morning_end_time?></small>
            <br> <small><b>Evening Shift:</b> <?= $evening_start_time ." to ".$evening_end_time?></small></br>
          </div>
          <div class="row">
            <!--								<div class="col-6">-->
            <div class="form-group">
              <div id=" " class="clearfix">  <?= "$bookerror";?> </div>

              <div>
                <label> <h5>Select Date</h5></label> <br>
                <input type="date" class="input-group-addon "  name="date" placeholder="Select Date" required min= "<?= $curr_date ?>" >
                <!--										<input class="input-group date" type="date" id="date" data-lang="en" data-min-year="2019" name="date"/>-->
              </div>
            </div>
            <!--								</div>-->
            <div>
              <label> <h5>Select Shift</h5></label> <br>
              <input type = "radio" required name = "shift" value = "0" />
              <label for = "shift">Morning Shift</label>
              <input type = "radio" required name = "shift"  value = "1" />
              <label for = "1">Evening Shift</label> <br> <br>

              <input type="hidden" name="doc_id" value="<?=$doc_id?>">
            </div>
          </div>
          <!--						disable book now button if user is not logged in-->
          <?php
          if(isset($_SESSION['login_user']))
          {
            echo "<input type='submit' style = 'width:100%' class='btn_1 full-width' value='Book now'><br>";


          }
          else
          {
            echo "<input type='submit' style = 'width:100%' class='btn_1 full-width' disabled = 'true' title='Login to Book' value='Book now'><br>";
          }



          ?>



        </form>
      </div>
      <!-- /box_general -->
    </aside>
    <!-- /asdide -->

    <div class="col-xl-8 col-lg-8">
      <nav id="secondary_nav">
        <div class="container">
          <ul class="clearfix">
            <li><a href="#section_1" class="active">General info</a></li>
            <li><a href="#section_2">Reviews</a></li>
            <li><a href="#sidebar">Booking</a></li>
          </ul>
        </div>
      </nav>

      <div id="section_1">
        <div class="box_general_3">

          <div class="profile">
            <div class="row">
              <div class="col-lg-5 col-md-4">
                <figure>
                  <?= "$image";?>
                </figure>
              </div>
              <div class="col-lg-7 col-md-8">
                <!--										<small>Primary care - Internist</small>-->
                <h1><?= $user_name ?> </h1>
				 <h6>Rated <?= substr($avg_rating,0,4) ?> on average by <?=$rate_times?>  users</h6>
                <span class="rating">
                  <!--                                          TO DO GET STARS from databse-->

                  <?php  
				  
                                            $x = 0;
											$avg_rating = round($avg_rating,0);
											
                                            if($avg_rating <= 5)
                                            	{
                                            		for ($x; $x < $avg_rating; $x++) 
                                            			{
                                            				echo "<i class='icon_star voted'></i>";
                                            			}
                                              		$diff = 5-$x;
                                              		for ($i = 0; $i < $diff; $i++) 
                                            			{
                                            				echo "<i class='icon_star'></i>";
                                            			}
                                            	}
                                            
                                          
                                              else 
                                              	{
												  echo ('<i class="icon_star"></i>
												<i class="icon_star"></i>
												<i class="icon_star"></i>
												<i class="icon_star"></i>
												<i class="icon_star "></i>');
											  	}
                                              
                                               
?>  

                  
                  <!--											<a href="./badges.php" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>-->
                </span>
                <ul class="statistic">
                  <li><?= $views ?> Views</li>
                  <li><?= $patients ?>  Patients</li>
                </ul>
                <ul class="contacts">
                  <li>
                    <h6>Address</h6>
                    <?= "$district";?>
                    <!--												<a href=""> <strong>View on map</strong></a>-->

                  </li>
                  <li>
                    <h6>Phone</h6> <a href="tel://01942-246579">+01942-246579</a> - <a href="tel://01942-246578">+01942-246578</a></li>
                  </ul>
                </div>
              </div>
            </div>

            <hr />

            <!-- /profile -->

            <div class="indent_title_in">
              <i class="pe-7s-user"></i>
              <h3>Professional statement</h3>
<!--               retrive details from table qualifications-->
              <?php 
               $query1="SELECT * FROM tb_qualifications where doct_id = $doc_id";
            $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
            $cdrow1=mysqli_fetch_array($result1);
              $degree = strtoupper($cdrow1['degree']);
              $institute = strtoupper($cdrow1['institute']);
              $experience = $cdrow1['experience'];
              
              ?>
              <p><?= $degree ?> from ( <?= $institute ?> ), <?= $experience ?> Years Experience</p>
              </div>
              <div class="wrapper_indent">
                <p>Dr. <?= $user_name ?> is a <?= $spec1,$spec2 ?> from <?= $district ?> and has an experience of  <?= $experience ?> years in this field. Dr. <?= $user_name ?> has done <?= $degree ?> from <?= $institute ?>.
                </p>
                  <!--TO DO add fields from database									She completed MBBS from All India Institute of Medical Sciences, Patna in 1962,MD - General Medicine from All India Institute of Medical Sciences, New Delhi in 1966 and DM - Cardiology from All India Institute of Medical Sciences, New Delhi in 1969.She is a member of Delhi Medical Council. Some of the services provided by the doctor are: Cardiography and Chest Pain Treatment etc.</p>-->
                  <h6>Specializations</h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <ul class="bullets">
                        <li><?= $spec1 ?></li>
<!--                        <li><?= $spec2 ?></li>-->
                        
                    </div>
                    <!--
                    <div class="col-lg-6">
                    <ul class="bullets">
                    <li>Abdominal Radiology</li>
                    <li>Addiction Psychiatry</li>
                    <li>Adolescent Medicine</li>
                    <li>Cardiothoracic Radiology </li>
                  </ul>
                </div>
              -->
            </div>
            <!-- /row-->
          </div>
          <!-- /wrapper indent -->

          <hr />

<!--
          <div class="indent_title_in">
            <i class="pe-7s-news-paper"></i>
            <h3>Education</h3>
            <p> AIMS Delhi .</p>
          </div>
          <div class="wrapper_indent">
            <p></p>
            							//	TO DO details from database
            <h6>Curriculum</h6>
            <ul class="list_edu">
              <li><strong>AIMS PATNA </strong> - MBBS </li>
              <li><strong>AIMS DELHI </strong> -  M.D</li>
              <li><strong>AIMS </strong> - D.M</li>
            </ul>
          </div>
-->
          <!--  End wrapper indent -->

          <hr />

          <!--
          <div class="indent_title_in">
          <i class="pe-7s-cash"></i>
          <h3>Prices &amp; Payments</h3>

        </div>
        <div class="wrapper_indent">

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
    <td>200 Rupees </td>
  </tr>
  <tr>
  <td>General consultation</td>
  <td>300 Rupees </td>
</tr>
<tr>
<td>Back Pain</td>
<td>100 Rupees </td>
</tr>
<tr>
<td>Diabetes Consultation</td>
<td>400 Rupees </td>
</tr>
<tr>
<td>Eating disorder</td>
<td>350 Rupees </td>
</tr>
<tr>
<td>Foot Pain</td>
<td>250 Rupees </td>
</tr>
</tbody>
</table>
</div>
/wrapper_indent
</div>
-->
<!-- /section_1 -->
</div>
<!-- /box_general -->

<div id="section_2">
  <div class="box_general_3">
    <div class="reviews-container">
      <!--			rating box from here-->
      <!--						  will disabble 5 star rating box if user not logged in-->
      <?php
      if(isset($_SESSION['login_user']))
      {
        echo ('<p align = "center"> <h5 align ="center">Rate Doctor</h5></p>

        <div class="rate">
        <div id="1" class="btn-1 rate-btn"></div>
        <div id="2" class="btn-2 rate-btn"></div>
        <div id="3" class="btn-3 rate-btn"></div>
        <div id="4" class="btn-4 rate-btn"></div>
        <div id="5" class="btn-5 rate-btn"></div>
        </div>
        <br>');
      }
      ?>

      <script>
      $(function(){
        $('.rate-btn').hover(function(){
          $('.rate-btn').removeClass('rate-btn-hover');
          var therate = $(this).attr('id');
          for (var i = therate; i >= 0; i--) {
            $('.btn-'+i).addClass('rate-btn-hover');
          };
        });

        $('.rate-btn').click(function(){
          var therate = $(this).attr('id');
          var dataRate = 'act=rate&post_id=<?php echo $doc_id; ?>&rate='+therate; //
          $('.rate-btn').removeClass('rate-btn-active');
          for (var i = therate; i >= 0; i--) {
            $('.btn-'+i).addClass('rate-btn-active');
          };
          $.ajax({
            type : "POST",
            url : "ajax.php",
            data: dataRate,
            success:function(){document.location.reload();}
          });
        });
      });
    </script>




    <!--	end rating box					-->
    <br/> <br />
    <div class="row">
      <div class="col-lg-3">
        <div id="review_summary">

           <strong><?php echo substr($rate_value,0,3); ?></strong>





          <div class="rating">

            <!--												<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>-->
          </div>
          <small>Based on <?php echo substr($rate_times,0,3); ?> reviews</small>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-10 col-9">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?= $fivestars ?>%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="col-lg-2 col-3"><small><strong>5 stars</strong></small></div>
        </div>
        <!-- /row -->
        <div class="row">
          <div class="col-lg-10 col-9">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width:<?= $fourstars ?>%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="col-lg-2 col-3"><small><strong>4 stars</strong></small></div>
        </div>
        <!-- /row -->
        <div class="row">
          <div class="col-lg-10 col-9">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?= $threestars ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="col-lg-2 col-3"><small><strong>3 stars</strong></small></div>
        </div>
        <!-- /row -->
        <div class="row">
          <div class="col-lg-10 col-9">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?= $twostars ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="col-lg-2 col-3"><small><strong>2 stars</strong></small></div>
        </div>
        <!-- /row -->
        <div class="row">
          <div class="col-lg-10 col-9">
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?= $onestars ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="col-lg-2 col-3"><small><strong>1 stars</strong></small></div>
        </div>
        <!-- /row -->
      </div>
    </div>
    <!-- /row -->

    <hr />
    <!-- commnet box -->


    <!--						  will disabble comment box and button if user not logged in-->
    <?php
    if(isset($_SESSION['login_user']))
    {
      echo"<form action ='#section_2' method='post'>
      <div class='form-group'>
      <div id = msg>   $msg </div>

      <label for='comment'><h6>Post Your Comment :</h6> </label>
      <textarea class='form-control' rows='5' name='comment' id='comment' placeholder='Enter Your Comment Here' required> </textarea>
      <br /> <br />
      <div class='rev-text'>
      <div>
      <p align='right'>
      <input type='submit' id='postcommnet' class='btn_1' value='Post Comment'><br>
      </p>
      </div>
      </div>
      </div>
      </form>";


    }
    else
    {
      // disable display nothing

      //							   echo "<input type='submit' id='postcommnet' class='btn_1' disabled = 'true'  title='Login to Post Comment' value='Post                          Comment'><br>";
    }



    ?>







    <!--                </div>-->


    <!-- End Commnet box -->



  </div>
  <!-- End review-container -->

</div>

<!-- - - - - - - - - - - - - - - - COMMENTS BEGIN HERE - - - - - - - - - - - -->

  <div class="box_general_3">
    <h4>Comments</h4>
    <div class="" id="comments">
    </div>
    <input type='hidden' value='0' id='offset' />
    <input type='hidden' value='<?= $doc_id ?>' id='doc_id' />
    <div id="loadmore" class="btn btn-primary" style="width:100%">Load More</div>
  </div>
<!-- - - - - - - - - - - - - - - - COMMENTS END HERE - - - - - - - - - - - -->

</div>
<!-- /section_2 -->
</div>
<!-- /col -->

</div>
<!-- /row -->
</div>
<!-- /container -->

<script src="js/loadmore.js" charset="utf-8"></script>

</main>
<?php include("footer.php"); ?>
<?php
unset($_SESSION['var']);
unset($bookerror);
?>
