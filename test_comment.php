<?php include("config.php");
include("session.php");
$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;

echo ($doc_id);
echo ($pat_id);

if($_SERVER["REQUEST_METHOD"] == "POST") {
 $comment = mysqli_real_escape_string($conn,$_POST['comment']);
 $sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
 mysqli_query($conn, $sql);
 if(mysqli_query($conn, $sql)){
    echo '<script type="text/javascript">
    alert("comment Sucessfully")
    </script> ';
    } else {
    echo '<script language="javascript">';
    echo '</script>';
    echo "ERROR: Could not able to execute $sql. ". mysqli_error($conn);
        }
   


 mysqli_close($conn);
}


?>

<div class="box_general_3 booking">
						<form action ="" method="post">
							<div >
                            <textarea rows="4" cols="50" name ="comment" placeholder="Enter Your Comment Here">
                    </textarea>
                               
                            </div>
<!--								<input type="hidden" name="doc_id" value="<?=$comment?>">-->
							
                    <input type="submit" style = "width:100%" class="btn_1 full-width" value="Book now"><br>

						</form>
					</div>
