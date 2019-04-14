
<?php
include("header.php");
include("config.php");
$bookerror = $_SESSION['var'];
$msg = " ";

$curr_date = date("Y-m-d"); // variable gets current date
$clinic_id = isset($_GET['clinic_id'])? mysqli_real_escape_string($conn,$_GET['clinic_id']):null;
$pat_id = isset($_SESSION['id'])? mysqli_real_escape_string($conn,$_SESSION['id']):null;
$doc_id = $clinic_id;
if($clinic_id!=null){
  $query1="SELECT * FROM vw_clinic where clinic_id = $clinic_id";
  $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $cdrow1=mysqli_fetch_array($result1);
  if($cdrow1!=null){
    $clinic_name = $cdrow1["clinic_name"];
    $district = $cdrow1['district'];
    $address = $cdrow1['address'];
    $phone = $cdrow1['clinic_phone'];
    $image = "<img src = 'data:image/jpeg;base64,".base64_encode( $cdrow1["photo"])."' width='255' height='255' /><br/>";
    $views = $cdrow1['views'];
    $avg_rating = $cdrow1['avg_rating'];
    $rated_by = $cdrow1['rated_by'];

  }

  // TO GET DATA FROM RATING
  //here doc_id = clinic_id
  $query = mysqli_query($conn,"SELECT * FROM tb_rating where doc_id = $clinic_id");
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

  $sql = "Update tb_clinic set rated_by = $rate_times,avg_rating = $rate_value,views = $views+1 where clinic_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());

  //	queries to get number of 5,4,3,2,1, star ratiings from db
  $sql = "SELECT count(*) as total from tb_rating where doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $total = $row['total'];

  $sql = "SELECT count(*) as stars from tb_rating where rate = 5 and doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $fivestars = $row['stars'];
  $fivestars = ($total>0)?($fivestars / $total) *100:0;

  // get number of four stars
  $sql = "SELECT count(*) as stars from tb_rating where rate = 4 and doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $fourstars = $row['stars'];
  $fourstars = ($total>0)?($fourstars / $total) *100:0;

  $sql = "SELECT count(*) as stars from tb_rating where rate = 3 and doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $threestars = $row['stars'];
  $threestars = ($total>0)?($threestars / $total) *100:0;

  $sql = "SELECT count(*) as stars from tb_rating where rate = 2 and doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $twostars = $row['stars'];
  $twostars = ($total>0)?($twostars / $total) *100:0;

  $sql = "SELECT count(*) as stars from tb_rating where rate = 1 and doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $onestars = $row['stars'];
  $onestars = ($total>0)?($onestars / $total) *100:0;


  $sql = "SELECT count(*) as t_comments from comments where doc_id = $clinic_id";
  $res = mysqli_query($conn,$sql) or die ("Query to get data from firsttable failed: ".mysqli_error());
  $row = mysqli_fetch_array($res);
  $total_comments = $row['t_comments'];
}
else die("Clinic id not found");
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $comment = mysqli_real_escape_string($conn,$_POST['comment']);
  $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$clinic_id','$comment')";

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
<html>
<main>
  <div class="container margin_60">
    <div class="row">
      <aside class="col-xl-3 col-lg-4" id="sidebar">
        <div class="box_profile">
          <figure>
            <?= "$image";?>
          </figure>
          <!--						<small>Primary care - Internist</small>-->
          <h1><?= $clinic_name ?> </h1>
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

            <small>( <?= $rated_by ?> )</small>
          </span>
          <ul class="statistic">
            <li><?= $views ?> Views</li>

          </ul>
          <ul class="contacts">
            <li><h6>Address</h6><?= $address ?></li>
            <li><h6>Phone</h6><?= $phone ?></li>
          </ul>
        </aside>
        <!-- /asdide -->

        <div class="col-xl-9 col-lg-8">

          <div class="tabs_styled_2">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-expanded="true">General info</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book">Doctors Avalaible</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">Reviews</a>
              </li>
            </ul>
            <!--/nav-tabs -->

            <div class="tab-content">

              <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <p class="lead add_bottom_30"><?=$clinic_name?> is located at <?=$address?> in district <?=$district?>.</p>
                <div class="indent_title_in">
                  <i class="pe-7s-user"></i>
                  <h3>Professional statement</h3>
                  <!--									<p>Mussum ipsum cacilds, vidis litro abertis.</p>-->
                </div>
                <div class="wrapper_indent">
                  <!--									<p>Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Nullam mollis. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapi.</p>-->
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

                <!--
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
        -->
        <!--  End wrapper indent -->

        <hr />

        <!--
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
-->
<!--  End wrapper_indent -->

</div>
<!-- /tab_2 -->

<div class="tab-pane fade " id="book" role="tabpanel" aria-labelledby="book-tab">
  <p class="lead add_bottom_30" align="center">List Of Doctors Avalaible Here</p>
  <form />
  <div class="container margin_60_35" >
    <div class="row" >
      <div class="col-lg-7" >
        <?php
        $q= "Select * from tb_clinic_docs where clinic_id = $clinic_id";
        $result=mysqli_query($conn,$q) or die ("Query to get data from firsttable failed: ".mysqli_error());
        $count = mysqli_num_rows($result);

        while ($cdrow=mysqli_fetch_array($result))
        {
          $doc_id=$cdrow["doc_id"];
          $query = "Select * from vw_doctor where doc_id = $doc_id";
          $result1 = mysqli_query($conn,$query);
          $cdrow1 = mysqli_fetch_array($result1);

          $user_name=$cdrow1["user_name"];
          $specialization = $cdrow1["specialization"];
          $image = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow1["photo"])."' />";
          $rate_times = $cdrow1['rated_by'];
          $avg_rating = $cdrow1['avg_rating'];
          ?>
          <div class="strip_list wow fadeIn" >
            <a href="#0" class="wish_bt"></a>
            <figure>
              <a href="./detail-page.php"><img src="" alt="" /></a>
              <?= "$image";?>
            </figure>
            <?php if(strlen($specialization) > 24)
            {
              $spec_Array =  explode (",", $specialization);
              $spec1 = $spec_Array[0];
              $spec2 = $spec_Array[1];
              $spec3 = $spec_Array[2];
              $spec4 = $spec_Array[3];
              echo ("<small>$spec1,$spec2</small>");
              echo ("<small>$spec3,$spec4</small>");

            }
            else
            {
              echo ("<small>$specialization</small>");
            }
            ?>
            <?php
            $query1="SELECT * FROM tb_qualifications where doct_id = $doc_id";
            $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
            $cdrow1=mysqli_fetch_array($result1);
            $degree = strtoupper($cdrow1['degree']);
            $institute = strtoupper($cdrow1['institute']);
            $experience = $cdrow1['experience'];

            ?>

            <?= "<h3>$user_name</h3>";?>
            <p><?= $degree ?> ( <?= $institute ?> ), <?= $experience ?> Years Experience</p>
            <!--						code to display stars from database-->
            <span class="rating">

              <?php
              $avg_rating = substr($avg_rating,0,4);
              echo("<small>($avg_rating) </small>");
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
              <small>(<?php echo $rate_times; ?>)</small></span>
              <!--						<a href="./badges.php" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>-->
              <ul>
                <li><a href="#0" onclick="onHtmlClick('Doctors', 0)" class="btn_listing">View on Map</a></li>
                <li><a href=" ">Directions</a></li>
                <li><a href="./detail-page.php?doc_id=<?= $doc_id ?>" class="btn_listing">View Profile</a></li>
              </ul>
            </div>


            <!--                                here-->


            <?php

          }

          ?>



          <!-- /tab_1 -->

        </div>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
    <div class="reviews-container">
      <!--			rating box from here-->
      <!--						  will disabble 5 star rating box if user not logged in-->
      <?php
      if(isset($_SESSION['login_user']))
      {

        echo ('<p align = "center"> <h5 align ="center">Rate Clinic</h5></p>

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
          var dataRate = 'act=rate&post_id=<?php echo $clinic_id; ?>&rate='+therate; //
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
        echo"<form action ='#reviews' method='post'>
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

      <!-- - - - - - - - - - - - - - - - COMMENTS BEGIN HERE - - - - - - - - - - - -->
      <div class="box_general_3">
        <h4>Showing <i id="count"> 3 </i> of <i><?=$total_comments?></i> Comments</h4>
        <?php
        $rowperpage = 3;
        $query="SELECT * FROM vw_comments  WHERE doc_id= $clinic_id ORDER BY date DESC LIMIT 0, $rowperpage";
        $result=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
        $count = mysqli_num_rows($result);
        if($count>0)
        {
          while ($cdrow=mysqli_fetch_array($result))
          {

            $pat_name=$cdrow["pat_name"];
            $comment = $cdrow["comment"];
            $date = $cdrow["date"];
            $pat_id = $cdrow['pat_id'];
            $pic = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow["photo"])."' width = '60px' height ='60px'/>";
            ?>

            <div class="review-box clearfix">
              <div class ='rev-thumb'><?= $pic ?></div>
              <div class="rev-content">
                <div class="rating">
                  <?php
                  $query1 = "Select rate as rating from tb_rating where doc_id = $clinic_id and pat_id = $pat_id ORDER BY timestamp DESC LIMIT 1";
                  $result1=mysqli_query($conn,$query1) or die ("Query to get data from first table failed: ".mysqli_error());
                  $cdrow1=mysqli_fetch_array($result1);
                  $rating = $cdrow1['rating'];
                  $x = 0;
                  $avg_rating = round($rating,0);

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

                </div>
                <div class="rev-info">
                  <h6><?= $pat_name ?></h6>  <small><?= $date; ?></small>
                </div>
                <div class="rev-text">
                  <p><?= $comment ?></p>
                </div>
              </div>
            </div>
            <?php
          }?>
          <div class="" id="comments">
          </div>
          <input type='hidden' value='3' id='offset' />
          <input type='hidden' value='<?= $clinic_id ?>' id='doc_id' />
          <button id="loadmore" class="btn btn-primary" style="width:100%">Load More</button>
        </div>

      </div>

    <?php }
    else
    {
      echo('<h4>No Comments Yet!</h4>');
    }
    ?>


    <!-- End review-container -->

  </div>
  <!-- - - - - - - - - - - - - - - - COMMENTS END HERE - - - - - - - - - - - -->

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
</html>

<script src="js/loadmore.js" charset="utf-8"></script>

<?php include("footer.php"); ?>
