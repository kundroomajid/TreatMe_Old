<pre>
<?php
  include("config.php");
  include('session.php');
  $id = isset($_SESSION['id'])?$_SESSION['id']:null;
  if($id!=null && isset($_POST['degree']) && isset($_POST['year']) && isset($_POST['institute'])){
    $a = transposeData($_POST);
    //print_r($a);
    $q = "DELETE FROM tb_doceducation where doc_id=$id";
    $result = mysqli_query($conn,$q) or die ('<script type="text/javascript"> alert("Deleteion Failed "); window.location = "./welcomed.php"; </script> ');

    $q = "INSERT INTO tb_doceducation(doc_id,degree,year,institute) VALUES ";
    if(count($a)>1){
      for($i=0;$i<count($a)-1;$i++){
        $degree = $a[$i]['degree'];
        $year = $a[$i]['year'];
        $institute = $a[$i]['institute'];
        $q = $q."($id,'$degree',$year,'$institute'), ";
      }
      $degree = $a[$i]['degree'];
      $year = $a[$i]['year'];
      $institute = $a[$i]['institute'];
      $q = $q."($id,'$degree',$year,'$institute');";
    }else if (count($a) == 1){
      $q = $q."($id,'$degree',$year,'$institute');";
    }
    $result = mysqli_query($conn,$q) or die ('<script type="text/javascript"> alert("Deleteion Failed "); window.location = "./welcomed.php"; </script> ');
    echo '<script type="text/javascript"> alert("Updated Successfully "); window.location = "./welcomed.php"; </script>';
  }else{
    echo "Illegal entry";
  }

  function transposeData($data) {
    $retData = array();
    foreach ($data as $row => $columns) {
      foreach ($columns as $row2 => $column2) {
        $retData[$row2][$row] = $column2;
      }
    }
    return $retData;
  }
?>