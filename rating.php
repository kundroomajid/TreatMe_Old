<?php
//  header("Content-Type: application/json; charset=UTF-8");

include_once('config.php');


  class JsObj{
    public $rating;
    public $doc_id;
    public $error;
    function __construct() {
        $this.error=null;
    }
  }

  $ratings = new JsObj();

  if(isset($_POST['doc_id']) && $_POST['doc_id']!=null){
    $ratings->rating=3.5;
    $ratings->doc_id=$_REQUEST['doc_id'];
    $jobj = json_encode($ratings);
    echo $jobj;
  }
?>
