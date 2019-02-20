<html>
<?php
include("header.php");
include("config.php");
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
    $image = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow1["photo"])."' />";

  }
}
else die("doc id not found");
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $comment = mysqli_real_escape_string($conn,$_POST['comment']);
  $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
  if(mysqli_query($conn, $sql)){
    echo '<script type="text/javascript">
    alert("comment Sucessfully")
    </script> ';
  } else {
    echo '<script language="javascript">';
    echo '</script>';
    echo "ERROR: Could not able to execute $sql. ". mysqli_error($conn);
  }

}
?>

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
                  <span class="rating">
                    <i class="icon_star voted"></i>
                    <i class="icon_star voted"></i>
                    <i class="icon_star voted"></i>
                    <i class="icon_star voted"></i>
                    <i class="icon_star"></i>
                    <small>(145)</small>
                    <a href="./badges.php" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>
                  </span>
                  <ul class="statistic">
                    <li>854 Views</li>
                    <li>124 Patients</li>
                  </ul>
                  <ul class="contacts">
                    <li>
                      <h6>Address</h6>
                      <?= "$district";?>
                      <a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x0:0xa6a9af76b1e2d899!2sAssistance+%E2%80%93+H%C3%B4pitaux+De+Paris!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="_blank"> <strong>View on map</strong></a>
                    </li>
                    <li>
                      <h6>Phone</h6> <a href="tel://000434323342">+01942-246579</a> - <a href="tel://000434323342">+01942-246578</a></li>
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
                  <p>Dr. Seerat Mohammad is a Cardiologist in Srinagar and has an experience of 49 years in this field. Dr. Seerat at The Caring Touch Laser & Implant Centre in New Rajendra Nagar, Delhi. She completed MBBS from All India Institute of Medical Sciences, Patna in 1962,MD - General Medicine from All India Institute of Medical Sciences, New Delhi in 1966 and DM - Cardiology from All India Institute of Medical Sciences, New Delhi in 1969.

                    She is a member of Delhi Medical Council. Some of the services provided by the doctor are: Cardiography and Chest Pain Treatment etc.</p>
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
                  <hr />
                  <div class="indent_title_in">
                    <i class="pe-7s-news-paper"></i>
                    <h3>Education</h3>
                    <p> AIMS Delhi .</p>
                  </div>
                  <div class="wrapper_indent">
                    <p></p>
                    <h6>Curriculum</h6>
                    <ul class="list_edu">
                      <li><strong>AIMS PATNA </strong> - MBBS </li>
                      <li><strong>AIMS DELHI </strong> -  M.D</li>
                      <li><strong>AIMS </strong> - D.M</li>
                    </ul>
                  </div>
                  <!--  End wrapper indent -->
                  <hr />
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
                  <!--  /wrapper_indent -->
                </div>
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

                    <form action ="" method="post">
                      <div class="form-group">
                        <label for="comment"><h6>Post Your Comment :</h6></label>
                        <textarea class="form-control" rows="5" name="comment" id="comment" placeholder='Enter Your Comment Here' required></textarea>
                        <br /> <br />
                        <div class="rev-text">
                          <div>
                            <p align="right">

                              <!--						  will disabble comment button if user not logged in-->
                              <?php
                              if(isset($_SESSION['login_user']))
                              {

                                echo "<input type='submit' id='postcommnet' class='btn_1' value='Post Comment'><br>";


                              }
                              else
                              {
                                echo "<input type='submit' id='postcommnet' class='btn_1' disabled = 'true'  title='Login to Post Comment' value='Post Comment'><br>";
                              }



                              ?>


                            </p>
                          </div>
                        </div>
                      </div>
                    </form>


                    <!--                </div>-->


                    <!-- End Commnet box -->

                    <?php
                    $query="SELECT * FROM comments  WHERE doc_id=$doc_id ORDER BY date DESC";
                    $result=mysqli_query($conn,$query) or die ("$query <br/> failed. Query to get data from comments table failed: <br/>".mysqli_error());
                    $count = mysqli_num_rows($result);
                    if($count >=10)
                      $disp = 10;  // number of count displayed
                    else
                      $disp = $count;
                    ?>

                    <div class="col-md-6">

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

                          <?php   echo"<div class ='rev-thumb'>$pic</div>";?>

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
            <aside class="col-xl-4 col-lg-4" id="sidebar">
              <div class="box_general_3 booking">
                <form action ="book_appoinment.php">
                  <div class="title">
                    <h3>Book a Visit</h3>
                    <br><small><b>Morning Shift:</b> <?= $morning_start_time." to ".$morning_end_time?></small>
                    <br> <small><b>Evening Shift:</b> <?= $evening_start_time ." to ".$evening_end_time?></small></br>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">

                        <input class="form-control" type="date" name="date" required>
                        <!--										<input class="form-control" type="date" id="date" data-lang="en" data-min-year="2019" name="date"/>-->
                      </div>
                    </div>
                    <div>
                      <p>
                        <label>&nbsp;&nbsp;&nbsp; Select Shift</label> <br>
                        <input type = "radio" required
                        name = "shift"
                        value = "0" />
                        <label for = "shift">Morning Shift</label><br>
                        <input type = "radio" required
                        name = "shift"

                        value = "1" />
                        <label for = "1">Evening Shift</label><br>
                      </p>
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
          </div>
          <!-- /row -->
        </div>
        <!-- /container -->

</main>
<?php include("footer.php"); ?>
</html>
