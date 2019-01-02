<?php include("session.php");
$id = isset($_SESSION['id'])?$_SESSION['id']:null;
//for edit profile
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $gender = $_POST['gender'];
     $dob = $_POST['dob'];
     $address = $_POST['address'];
     $district = $_POST['district'];
     $pincode = $_POST['pin'];
     $bloodgroup = $_POST['bloodgroup'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    

$sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',gender = '$gender',dob = '$dob',district ='$district',pincode = '$pincode',blood_group = '$bloodgroup',height = '$height',weight = '$weight' WHERE user_id='$id'";
if(mysqli_query($conn, $sql))
{
   echo ' Details Saved <script type="text/javascript">
alert("Details Saved Sucessfully")
window.location = "./welcome.php";
</script> ';
} else
{
     echo ' Error <script type="text/javascript">
alert("Sorry Some error occured")
window.location = "./welcome.php";
</script> ';
    
}
mysqli_close($conn);


}


  ?>  