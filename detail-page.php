<?php
include("header.php");
include("config.php");
include_once('schedule_controller.php');

$bookerror = $_SESSION['var'];
$msg = " ";

$curr_date = date("Y-m-d"); // variable gets current date
$doc_id = isset($_GET['doc_id']) ? mysqli_real_escape_string($conn, $_GET['doc_id']) : null;
$pat_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$user_type = $_SESSION['user_type'];

$schedule = get_schedule($doc_id);
$schedule = ($schedule == "") ? "''" : $schedule;

if ($doc_id != null) {
    $query1 = "SELECT * FROM vw_doctor where user_id = $doc_id";
    $result1 = mysqli_query($conn, $query1) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $cdrow1 = mysqli_fetch_array($result1);

    $query2 = "SELECT * FROM tb_doctor where doc_id = $doc_id";
    $result2 = mysqli_query($conn, $query2) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $cdrow = mysqli_fetch_array($result2);

    //	queries to get number of 5,4,3,2,1, star ratiings from db
    $sql = "SELECT count(*) as total from tb_rating where doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $total = $row['total'];

    $sql = "SELECT count(*) as stars from tb_rating where rate = 5 and doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $fivestars = $row['stars'];
    $fivestars = ($total > 0) ? ($fivestars / $total) * 100 : 0;

    // get number of four stars
    $sql = "SELECT count(*) as stars from tb_rating where rate = 4 and doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $fourstars = $row['stars'];
    $fourstars = ($total > 0) ? ($fourstars / $total) * 100 : 0;

    $sql = "SELECT count(*) as stars from tb_rating where rate = 3 and doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $threestars = $row['stars'];
    $threestars = ($total > 0) ? ($threestars / $total) * 100 : 0;

    $sql = "SELECT count(*) as stars from tb_rating where rate = 2 and doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $twostars = $row['stars'];
    $twostars = ($total > 0) ? ($twostars / $total) * 100 : 0;

    $sql = "SELECT count(*) as stars from tb_rating where rate = 1 and doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $onestars = $row['stars'];
    $onestars = ($total > 0) ? ($onestars / $total) * 100 : 0;

    $sql = "SELECT count(*) as t_comments from comments where doc_id = $doc_id";
    $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $row = mysqli_fetch_array($res);
    $total_comments = $row['t_comments'];

    if ($total_comments > 3) {
        $comment_count = 3;
    } else {
        $comment_count = $total_comments;
    }


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
        $user_phone = $cdrow1['user_phone'];
        if (strlen($specialization) > 24) {
            $spec_Array = explode(",", $specialization);
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
        $res = mysqli_query($conn, $sql) or die ("Query to get data from firsttable failed: " . mysqli_error());

    }
} else die("doc id not found");

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
//    $comment_query = mysqli_query($conn, "SELECT * FROM comments WHERE doc_id = $doc_id and pat_id=$pat_id");
//    $comment_rows = mysqli_num_rows($comment_query);
//
//    if ($comment_rows == 0)
//        $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
//    else
//        $sql = "UPDATE comments SET comment = '$comment' WHERE doc_id = $doc_id and pat_id = $pat_id";
//    $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
//
//
//    if (mysqli_query($conn, $sql)) {
//        $msg = '<div class= "alert alert-info alert-dismissible">
//    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//    Comment Posted Sucessfully</div>';
//        echo '<script type="text/javascript">
//    //    alert("comment Sucessfully")
//    </script> ';
//    } else {
//
//        $msg = '<div class="alert alert-danger alert-dismissible">
//    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//    Something went Wrong
//    </div>';
//
//    }
//    unset($comment);
//}

if (isset($_SESSION['login_user'])) {
    $query1 = "SELECT user_name FROM tb_user where user_id = $pat_id ";
    $result1 = mysqli_query($conn, $query1) or die ("Query to get data from firsttable failed: " . mysqli_error());
    $cdrow1 = mysqli_fetch_array($result1);
    $pat_name = $cdrow1["user_name"];


}


?>
<head>
    <!-- SPECIFIC CSS -->
    <link href="css/date_picker.css" rel="stylesheet">
</head>
<main>
    <div id="breadcrumb">
        <div class="container">
            <!--            <ul>-->
            <!--                <li><a href="#">Home</a></li>-->
            <!--                <li><a href="#">Category</a></li>-->
            <!--                <li>Page active</li>-->
            <!--            </ul>-->
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="container margin_60">
        <div class="row">

            <aside class="col-xl-3 col-lg-4" id="sidebar">
                <div class="box_profile">
                    <figure>
                        <?= "$image"; ?>
                    </figure>
                    <!--                    <small>orthopedic</small>-->
                    <h1><?php echo($user_name) ?></h1>
                    <h6>Rated <?= substr($avg_rating, 0, 4) ?> on average by <?= $rate_times ?> users</h6>

                    <span class="rating">
                  <!--TO DO GET STARS from databse-->
                  <?php

                  $x = 0;
                  $avg_rating = round($avg_rating, 0);

                  if ($avg_rating <= 5) {
                      for ($x; $x < $avg_rating; $x++) {
                          echo "<i class='icon_star voted'></i>";
                      }
                      $diff = 5 - $x;
                      for ($i = 0; $i < $diff; $i++) {
                          echo "<i class='icon_star'></i>";
                      }
                  } else {
                      echo('<i class="icon_star"></i>
                    <i class="icon_star"></i>
                    <i class="icon_star"></i>
                    <i class="icon_star"></i>
                    <i class="icon_star "></i>');
                  }


                  ?>
                    </span>
                    <ul class="statistic">
                        <li><?= $views ?> Views</li>
                        <li><?= $patients ?> Patients</li>
                    </ul>
                    <ul class="contacts">
                        <li>
                            <h6>Clinic</h6>
                            <?= "$clinic_name"; ?>


                        </li>
                        <li>
                            <h6>Address</h6>
                            <?= "$clinic_address"; ?>
                            <?= "$district"; ?>
                            <!--												<a href=""> <strong>View on map</strong></a>-->

                        </li>
                        <li>
                            <h6>Phone</h6> <?php echo($user_phone) ?> </li>
                    </ul>
                </div>
            </aside>
            <!-- /asdide -->

            <div class="col-xl-9 col-lg-8">

                <div class="tabs_styled_2">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab"
                               aria-controls="book">Book an appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab"
                               aria-controls="general" aria-expanded="true">General info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                               aria-controls="reviews">Reviews</a>
                        </li>
                    </ul>
                    <!--/nav-tabs -->

                    <div class="tab-content">

                        <div class="tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
                            <p class="lead add_bottom_30">Just Select The date and Time to book an Appointment</p>
                            <form action="make_appointment.php" method="post">
                                <input type="hidden" name="doc_id" value="<?= $doc_id ?>"/>
                                <input type="hidden" name="pat_id" value="<?= $pat_id ?>"/>
                                <div class="main_title_3">
                                    <h3><strong>1</strong>Patient Name</h3>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12"><input class="form-control" name="pat_name" type="text"
                                                                  value="<?= $pat_name; ?>"
                                                                  placeholder="Enter Patient Name">
                                    </div>
                                </div>
                                <input type="hidden" name="doc_id" value="<?= $doc_id ?>">
                                <div id=" " class="clearfix">  <?= "$bookerror"; ?> </div>

                                <div class="main_title_3">
                                    <h3><strong>2</strong>Select Appointment date</h3>
                                </div>
                                <div class="form-group">
                                    <div id="calendar">
                                        <input type="date" name="date" id="date"
                                               onchange="calendar_event(this,<?= $doc_id ?>)" style="display:none"/>
                                    </div>
                                    <input type="hidden" id="my_hidden_input">
                                    <ul class="legend">
                                        <li><strong></strong>Available</li>
                                        <li><strong></strong>Not available</li>
                                    </ul>
                                </div>
                                <div class="main_title_3">
                                    <h3><strong>3</strong>Select Appointment Time</h3>
                                </div>
                                <div class="row justify-content-center add_bottom_45">
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
                                <!-- /row -->

                                <div class="main_title_3">
                                    <h3><strong>4</strong>Select Location</h3>
                                </div>
                                <!--                              TO DO Add multiple addressses of doctor here and to make-->
                                <!--                                user select one location-->

                                <hr>
                                <!--						disable book now button if user is not logged in-->
                                <?php
                                if (isset($_SESSION['login_user'])) {
                                    echo "<input type='submit' style = 'width:100%' class='btn_1 full-width' value='Book now'><br>";


                                } else {
                                    echo "<input type='submit' style = 'width:100%' class='btn_1 full-width' disabled = 'true' title='Login to Book' value='Book now'><br>";
                                }


                                ?>
                            </form>
                        </div>
                        <!-- /tab_1 -->

                        <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <!--                          pper_indent -->

                            <div class="indent_title_in">
                                <i class="pe-7s-user"></i>
                                <h3>Professional statement</h3>
                                <!--               retrive details from table qualifications-->
                                <?php
                                $query1 = "SELECT * FROM tb_qualifications where doct_id = $doc_id";
                                $result1 = mysqli_query($conn, $query1) or die ("Query to get data from firsttable failed: " . mysqli_error());
                                $cdrow1 = mysqli_fetch_array($result1);
                                $degree = strtoupper($cdrow1['degree']);
                                $institute = strtoupper($cdrow1['institute']);


                                ?>
                                <p><?= $degree ?> from ( <?= $institute ?> ), <?= $experience ?> Years Experience</p>
                            </div>
                            <div class="wrapper_indent">
                                <p>Dr. <?= $user_name ?> is a <?= $spec1, $spec2 ?> from <?= $district ?> and has an
                                    experience of <?= $experience ?> years in this field. Dr. <?= $user_name ?> has
                                    done <?= $degree ?> from <?= $institute ?>.
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

                            <hr/>

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

                            <hr/>

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
                                        <td><?= "$fee" ?> Rupees</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tab_2 -->

                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="box_general_3">
                                <div class="reviews-container">
                                    <!--			rating box from here-->
                                    <!--						  will disabble 5 star rating box if user not logged in-->
                                    <?php
                                    if (isset($_SESSION['login_user']) && ($user_type == 'p')) {
                                        echo('<p align = "center"> <h5 align ="center">Rate Doctor</h5></p>

   
        <div class="rate">
        <div id="1" class="btn-1 rate-btn"></div>
        <div id="2" class="btn-2 rate-btn"></div>
        <div id="3" class="btn-3 rate-btn"></div>
        <div id="4" class="btn-4 rate-btn"></div>
        <div id="5" class="btn-5 rate-btn"></div>
        </div>
         <p><h6 id="rated"></h6></p>
        <br>');
                                    }
                                    ?>

                                    <script>
                                        $(function () {
                                            $('.rate-btn').hover(function () {
                                                $('.rate-btn').removeClass('rate-btn-hover');
                                                var therate = $(this).attr('id');
                                                for (var i = therate; i >= 0; i--) {
                                                    $('.btn-' + i).addClass('rate-btn-hover');
                                                }
                                                ;
                                            });

                                            $('.rate-btn').click(function () {
                                                var therate = $(this).attr('id');
                                                var dataRate = 'act=rate&post_id=<?php echo $doc_id; ?>&rate=' + therate; //
                                                $('.rate-btn').removeClass('rate-btn-active');
                                                for (var i = therate; i >= 0; i--) {
                                                    $('.btn-' + i).addClass('rate-btn-active');
                                                }
                                                ;
                                                $.ajax({
                                                    type: "POST",
                                                    url: "ajax.php",
                                                    data: dataRate,
                                                    success: function () {
                                                        document.getElementById('rated').innerHTML = 'Rated ' + therate + ' Stars'
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                    <!--	end rating box					-->
                                    <br/> <br/>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div id="review_summary">

                                                <strong><?php echo substr($rate_value, 0, 3); ?></strong>


                                                <div class="rating">

                                                    <!--												<i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>-->
                                                </div>
                                                <small>Based on <?php echo substr($rate_times, 0, 3); ?> reviews</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-lg-10 col-9">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: <?= $fivestars ?>%" aria-valuenow="90"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3"><small><strong>5 stars</strong></small>
                                                </div>
                                            </div>
                                            <!-- /row -->
                                            <div class="row">
                                                <div class="col-lg-10 col-9">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width:<?= $fourstars ?>%" aria-valuenow="95"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3"><small><strong>4 stars</strong></small>
                                                </div>
                                            </div>
                                            <!-- /row -->
                                            <div class="row">
                                                <div class="col-lg-10 col-9">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: <?= $threestars ?>%" aria-valuenow="60"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3"><small><strong>3 stars</strong></small>
                                                </div>
                                            </div>
                                            <!-- /row -->
                                            <div class="row">
                                                <div class="col-lg-10 col-9">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: <?= $twostars ?>%" aria-valuenow="20"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3"><small><strong>2 stars</strong></small>
                                                </div>
                                            </div>
                                            <!-- /row -->
                                            <div class="row">
                                                <div class="col-lg-10 col-9">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: <?= $onestars ?>%" aria-valuenow="0"
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-3"><small><strong>1 stars</strong></small>
                                                </div>
                                            </div>
                                            <!-- /row -->
                                        </div>
                                    </div>
                                    <!-- /row -->

                                    <hr/>
                                    <!-- commnet box -->

                                    <!--						  will disabble comment box and button if user not logged in-->
                                    <?php
                                    if (isset($_SESSION['login_user']) && $user_type == 'p') {
                                        echo "
        <div class='form-group'>
       <div id='msg'>
       
        </div>

        <label for='comment'><h6>Post Your Comment :</h6> </label>
        <textarea class='form-control' rows='5' name='comment' id='comment' placeholder='Enter Your Comment Here! (Your previous comment will be replaced by the current)' required> </textarea>
        <br /> <br />
        <div class='rev-text'>
        <div>
        <p align='right'>
     
        <button type='button' id='postcomment' class='btn_1' value='Post Comment' >Post Comment</button><br>
        </p>
        </div>
        </div>
        </div>"; ?>
                                        <script>
                                            $(document).ready(function () {
                                                $('#postcomment').click(function () {
                                                    var docId = <?php echo($doc_id)?>;
                                                    var patId = <?php echo($pat_id)?>;
                                                    var comment = $('#comment').val();
                                                    var dataRate = 'act=comment&doc_id=' + docId + '&pat_id=' + patId + '&comment=' + comment; //
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "ajax.php",
                                                        data: dataRate,
                                                        success: function () {
                                                            document.getElementById('msg').innerHTML = "<div class= 'alert alert-info alert-dismissible'>\n" +
                                                                "    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n" +
                                                                "     Comment Posted Sucessfully\n" +
                                                                "   </div>";
                                                            $('#comment').val('').empty();
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    <?php
                                    } else {
                                        // disable display nothing
                                        //							   echo "<input type='submit' id='postcommnet' class='btn_1' disabled = 'true'  title='Login to Post Comment' value='Post                          Comment'><br>";
                                    }
                                    ?>

                                    <!--                </div>-->

                                    <!-- - - - - - - - - - - - - - - - COMMENTS BEGIN HERE - - - - - - - - - - - -->
                                    <div class="box_general_3">
                                        <?php $no_comments = ($total_comments < 3) ? $total_comments : 3; ?>
                                        <h4>Showing <i id="count"> <?= $no_comments ?></i> of <i
                                                    id="total_comments"><?= $total_comments ?></i> Comments</h4>

                                        <?php

                                        $rowperpage = 3;
                                        $query = "SELECT * FROM vw_comments  WHERE doc_id= $doc_id ORDER BY date DESC LIMIT 0, $rowperpage";
                                        $result = mysqli_query($conn, $query) or die ("Query to get data from first table failed: " . mysqli_error());
                                        $count = mysqli_num_rows($result);
                                        if ($count > 0)
                                        {
                                        while ($cdrow = mysqli_fetch_array($result)) {
                                            $pat_name = $cdrow["pat_name"];
                                            $comment = $cdrow["comment"];
                                            $date = $cdrow["date"];
                                            $pat_id = $cdrow['pat_id'];
                                            $pic = "<img src ='data:image/jpeg;base64," . base64_encode($cdrow["photo"]) . "' width = '60px' height ='60px'/>";
                                            ?>

                                            <div class="review-box clearfix">
                                                <div class='rev-thumb'><?= $pic ?></div>
                                                <div class="rev-content">
                                                    <div class="rating">
                                                        <?php
                                                        $query1 = "Select rate as rating from tb_rating where doc_id = $doc_id and pat_id = $pat_id ORDER BY timestamp DESC LIMIT 1";
                                                        $result1 = mysqli_query($conn, $query1) or die ("Query to get data from first table failed: " . mysqli_error());
                                                        $cdrow1 = mysqli_fetch_array($result1);
                                                        $rating = $cdrow1['rating'];
                                                        $x = 0;
                                                        $avg_rating = round($rating, 0);

                                                        if ($avg_rating <= 5) {
                                                            for ($x; $x < $avg_rating; $x++) {
                                                                echo "<i class='icon_star voted'></i>";
                                                            }
                                                            $diff = 5 - $x;
                                                            for ($i = 0; $i < $diff; $i++) {
                                                                echo "<i class='icon_star'></i>";
                                                            }
                                                        } else {
                                                            echo('<i class="icon_star"></i>
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
                                        } ?>
                                        <div class="" id="comments">
                                        </div>
                                        <input type='hidden' value='3' id='offset'/>
                                        <input type='hidden' value='<?= $doc_id ?>' id='doc_id'/>
                                        <button id="loadmore" class="btn btn-primary" style="width:100%">Load More
                                        </button>
                                    </div>

                                </div>

                                <?php }
                                else {
                                    echo('<h4>No Comments Yet!</h4>');
                                }
                                ?>


                                <!-- End review-container -->

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


<script src="js/loadmore.js" charset="utf-8"></script>
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
    window.onload = function () {
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
            success: function (data) {
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
<?php include("footer.php"); ?>
<?php
unset($_SESSION['var']);
unset($bookerror);
?>
