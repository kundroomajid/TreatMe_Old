<?php
//  header("Content-Type: application/json; charset=UTF-8");

include_once('config.php');

$doc_id = isset($_REQUEST['doc_id'])? mysqli_real_escape_string($conn,$_REQUEST['doc_id']):null;
$rating = isset($_REQUEST['rating'])? mysqli_real_escape_string($conn,$_REQUEST['rating']):null;
$ratingObj = new JsObj();
if($doc_id!=null){

  $query = "SELECT rating_number,total_points FROM tb_doctor where doc_id=$doc_id";
  $result = $conn->query($query);
  $row = mysqli_fetch_assoc($result);
  $rating_number = $row['rating_number'];
  $total_points = $row['total_points'];
  if($rating!=null){
    $rating_number++;
    $total_points += $rating;
    $query = "UPDATE tb_doctor SET rating_number=$rating_number, total_points=$total_points WHERE doc_id=$doc_id";
    $conn->query($query);
  }

  $ratingObj->avg_rating=($rating_number!=0)?$total_points/$rating_number:0;
  $ratingObj->rating_number=$rating_number;
  $ratingObj->doc_id=$doc_id;

}else{
  $ratingObj->error='Nothing here';
}

$jobj = json_encode($ratingObj);
echo $jobj;

class JsObj{

  function __construct() {
    // $this.error = null;
  }
}
?>
