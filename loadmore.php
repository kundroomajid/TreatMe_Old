<?php
  include_once('config.php');
  $doc_id = isset($_REQUEST['doc_id'])? mysqli_real_escape_string($conn,$_REQUEST['doc_id']):null;
  $offset = isset($_REQUEST['offset'])? mysqli_real_escape_string($conn,$_REQUEST['offset']):0;

$rowperpage = 3;
  if($doc_id!=null)
  {
    $query="SELECT * FROM vw_comments  WHERE doc_id= $doc_id ORDER BY date DESC LIMIT $offset,$rowperpage";
    $result=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
    $count = mysqli_num_rows($result);
    if($count>0){
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
          $query1 = "Select rate as rating from tb_rating where doc_id = $doc_id and pat_id = $pat_id ORDER BY timestamp DESC LIMIT 1";
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
      }
    }
  }
?>
