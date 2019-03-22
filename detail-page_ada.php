<?php include("header.php");
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
  if($cdrow1!=null){
    $user_name = $cdrow1["user_name"];
    $district = $cdrow1['district'];
    $morning_start_time = (new DateTime($cdrow["morning_start_time"]))->format("h:i A");
    $morning_end_time = (new DateTime($cdrow["morning_end_time"]))->format("h:i A");
    $evening_start_time = (new DateTime($cdrow["evening_start_time"]))->format("h:i A");
    $evening_end_time = (new DateTime($cdrow["evening_end_time"]))->format("h:i A");
    $image = "<img src = 'data:image/jpeg;base64,".base64_encode( $cdrow1["photo"])."' width='250' height='200' /><br/>";
    $specialization = $cdrow1["specialization"];
    $exprience = 5; //TO DO add experience column in database and registration fields
    if(strlen($specialization) > 24)
    {
      $spec_Array =  explode (",", $specialization);
      $spec1 = $spec_Array[0];
      $spec2 = $spec_Array[1];

      echo ("<small>$spec1,$spec2</small>");
      echo ("<small>$spec3,$spec4</small>");

    }
    else
    {
      $spec1 = $specialization;
    }


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


<script src="rating/index.js"></script>
<script type="text/javascript">
function onload(event) {

  $.ajax({
    url : "rating.php",
    data : 'doc_id=' + <?= $doc_id ?>,
    type : "POST",
    success : function(data) {
      o = JSON.parse(data);
      // alert('rate is ' + o.avg_rating);
      starRating.setRating(o.avg_rating);
    }
  });




  var starRating = raterJs( {
    starSize:16,
    isBusyText: "Rating in progress. Please wait...",
    element:document.querySelector("#rater"),
    rateCallback:function rateCallback(rating, done) {
      var parentObject = this;
      var doc_id = <?= $doc_id ?>;
      //window.location = 'rating.php?doc_id='+doc_id+'&rating='+rating;
      $.ajax({
        url : "rating.php",
        data : 'doc_id=' + doc_id + '&rating='
        + rating,
        type : "POST",
        success : function(data) {
          o = JSON.parse(data);
          parentObject.setRating(o.avg_rating);
        }
      });

      starRating.disable();
      done();
    }
  });

}

window.addEventListener("load", onload, false);
</script>

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
                <small>Primary care - Internist</small>
                <h1><?= $user_name ?> </h1>
                <div id="rater"></div>
                <ul class="statistic">
                  <li>854 Views</li>
                  <li>124 Patients</li>
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
              <p>MBBS, MD - General Medicine, DM - Cardiology
                Cardiologist, 49 Years Experience</p>
              </div>
              <div class="wrapper_indent">
                <p>Dr. <?= $user_name ?> is a <?= $spec1,$spec2 ?> from <?= $district ?> and has an experience of  <?= $exprience ?> years in this field.

                  <!--TO DO add fields from database									She completed MBBS from All India Institute of Medical Sciences, Patna in 1962,MD - General Medicine from All India Institute of Medical Sciences, New Delhi in 1966 and DM - Cardiology from All India Institute of Medical Sciences, New Delhi in 1969.She is a member of Delhi Medical Council. Some of the services provided by the doctor are: Cardiography and Chest Pain Treatment etc.</p>-->
                  <h6>Specializations</h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <ul class="bullets">
                        <li><?= $spec1 ?></li>
                        <li><?= $spec2 ?></li>
                        <li>Adolescent Medicine</li>
                        <li>Cardiothoracic Radiology </li>
                      </ul>
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

          <div class="indent_title_in">
            <i class="pe-7s-news-paper"></i>
            <h3>Education</h3>
            <p> AIMS Delhi .</p>
          </div>
          <div class="wrapper_indent">
            <p></p>
            <!--								TO DO details from database-->
            <h6>Curriculum</h6>
            <ul class="list_edu">
              <li><strong>AIMS PATNA </strong> - MBBS </li>
              <li><strong>AIMS DELHI </strong> -  M.D</li>
              <li><strong>AIMS </strong> - D.M</li>
            </ul>
          </div>
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

      <hr />
      <!-- commnet box -->

      <!--			rating box from here-->

      
     
	<div class="rate">
		<div id="1" class="btn-1 rate-btn"></div>
        <div id="2" class="btn-2 rate-btn"></div>
        <div id="3" class="btn-3 rate-btn"></div>
        <div id="4" class="btn-4 rate-btn"></div>
        <div id="5" class="btn-5 rate-btn"></div>
	</div>
<br>
    <div class="box-result">
    	<?php
        	$query = mysqli_query($conn,"SELECT * FROM star"); 
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
        ?>
    <div class="result-container">
    	<div class="rate-bg" style="width:<?php echo $rate_bg; ?>%"></div>
        <div class="rate-stars"></div>
    </div>
        <p style="margin:5px 0px; font-size:16px; text-align:center">Rated <strong><?php echo substr($rate_value,0,3); ?></strong> out of <?php echo $rate_times; ?> Review(s)</p>
    </div>

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
      var dataRate = 'act=rate&post_id=<?php echo $post_id; ?>&rate='+therate; //
	  alert("rated");
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

      <!--	end rat	ing box					-->
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

      <?php
      $query="SELECT * FROM comments  WHERE doc_id= $doc_id ORDER BY date DESC";
      $result=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
      $count = mysqli_num_rows($result);
      ?>

      <div class="col-md-6">
        <?php
        if($count >=10)
        {
          $disp = 10;// number of count displayed
        }
        else {
          $disp = $count;
        }
        ?>

        <br />
        <h6 align = "center"><strong>Showing <?= "$disp";?></strong> of <?= "$count";?> comments <br /></h6>
      </div>
      <br />

      <!--								Display reviews starts -->

      <?php
      if($count == "0"){
        $output = '<h2>No Comments Yet!</h2>';

        echo "<small>$output</small>";

      }
      else
      {
        while ($cdrow=mysqli_fetch_array($result))
        {
          //                                    select the unique id of eaach patient
          $id = $cdrow["pat_id"];
          //                                    get user details from the ids retrived above
          $query2="SELECT * FROM vw_patient  WHERE user_id= $id";
          $resultuser=mysqli_query($conn,$query2) or die ("Inner query failed: ".mysqli_error());
          $cdrow2 = mysqli_fetch_array($resultuser);

          $user_name=$cdrow2["user_name"];
          $comments = $cdrow["comment"];
          $date = $cdrow["date"];
          $pic = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow2["photo"])."' width = '60px' height ='60px'/>";


          ?>
          <div class="review-box clearfix">

            <?php
            echo"<div class ='rev-thumb'>$pic</div>";?>
            <div class="rev-content">
              <div class="rating">
                <i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
              </div>
              <div class="rev-info">
                <?= "<h6>$user_name</h6>";?> </h6> <?= "	<small>$date</small>";?>
              </div>
              <div class="rev-text">
                <p>
                  <?= "	<small>$comments</small>";?>
                </p>
              </div>
            </div>
          </div>
          <!-- End review-box -->
          <?php
        }
      }
      ?>




    </div>
    <!-- End review-container -->
  </div>
</div>
<!-- /section_2 -->
</div>
<!-- /col -->

</div>
<!-- /row -->
</div>
<!-- /container -->

</main>
<?php
include("footer.php");
unset($_SESSION['var']);
unset($bookerror);
?>