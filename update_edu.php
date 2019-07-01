<pre>
<?php
  include("config.php");
  include('session.php');
  $id = isset($_SESSION['id'])?$_SESSION['id']:null;

  if($id!=null && isset($_POST['degree']) && isset($_POST['year']) && isset($_POST['institute'])){
    $a = transposeData($_POST);
    //print_r($a);
    $q = "DELETE FROM tb_qualifications where doct_id=$id";
    $result = mysqli_query($conn,$q) or die ( '<script type="text/javascript"> window.location = "./welcomed.php";
    </script> ');



    $q = "INSERT INTO tb_qualifications(doct_id,degree,institute,completion_year) VALUES ";
    if(count($a)>1){
      for($i=0;$i<count($a)-1;$i++){
        $degree = $a[$i]['degree'];
        $year = $a[$i]['year'];
        $institute = $a[$i]['institute'];
        $q = $q."($id,'$degree','$institute',$year), ";
      }
      $degree = $a[$i]['degree'];
      $year = $a[$i]['year'];
      $institute = $a[$i]['institute'];
      $q = $q."($id,'$degree','$institute',$year);";
    }else if (count($a) == 1){
      $degree = $a[0]['degree'];
      $year = $a[0]['year'];
      $institute = $a[0]['institute'];
      $q = $q."($id,'$degree','$institute',$year);";
      echo($q);
    }

    $result = mysqli_query($conn,$q) or die (mysqli_error($conn));
    echo '<script type="text/javascript">  window.location = "./welcomed.php"; </script>';
    $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Details saved  Sucessfully
    </div>';
  }else{
    echo "Illegal entry";
  }
$_SESSION['msg'] = $msg;


function transposeData($data) {
    $retData = array();
    foreach ($data as $row => $columns) {
      foreach ($columns as $row2 => $column2) {
        $retData[$row2][$row] = $column2;
      }
    }
    echo "trsnsnpose : \n";
    // print_r($retData);
    return $retData;
}
?>
