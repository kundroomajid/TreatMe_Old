<?php
   include('config.php');
session_start();
   // $_SESSION['login_user']= $myemail_id;
if(isset($_SESSION['login_user']))
{
   $user_check = $_SESSION['login_user'];


   $ses_sql = mysqli_query($conn,"select user_name,photo,user_email from tb_user where user_email = '$user_check' ");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['user_email'];
    $user = $row['user_name'];
//    $imagepic = "<img src ='data:image/jpeg;base64,".base64_encode( $row["photo"])."' />";
    $imagepic = "<img src = 'data:image/jpeg;base64,".base64_encode( $row["photo"])."' width='34' height='34' /><br/>";
    
}

   /*if(!isset($_SESSION['login_user'])){
      header("location:index.php");
   }*/
?>
