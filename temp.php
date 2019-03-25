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
      <div class ='rev-thumb'><?= $pic ?></div>
      <div class="rev-content">
        <div class="rating">
          <i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
        </div>
        <div class="rev-info">
          <h6><?= $user_name ?></h6>  <small><?= $date; ?></small>
        </div>
        <div class="rev-text">
          <p>            <small><?= $comments?></small>          </p>
        </div>
      </div>
    </div>
    <!-- End review-box -->
    <?php
  }
}
?>
