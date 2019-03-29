<?php
  include_once('config.php');
  $doc_id = isset($_REQUEST['doc_id'])?$_REQUEST['doc_id']:null;
  $offset = isset($_REQUEST['offset'])?$_REQUEST['offset']:0;

  if($doc_id!=null){
    $query="SELECT * FROM vw_comments  WHERE doc_id= $doc_id ORDER BY date DESC LIMIT 3 OFFSET $offset";
    $result=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
    $count = mysqli_num_rows($result);
    if($count>0){
      while ($cdrow=mysqli_fetch_array($result))
      {
        $pat_name=$cdrow["pat_name"];
        $comment = $cdrow["comment"];
        $date = $cdrow["date"];
        $pic = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow["photo"])."' width = '60px' height ='60px'/>";
?>
        <div class="review-box clearfix">
          <div class ='rev-thumb'><?= $pic ?></div>
          <div class="rev-content">
            <div class="rating">
              <i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
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
      }
    }
  }
?>
