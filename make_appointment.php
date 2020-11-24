<?php
include_once('header.php');
    include_once('config.php');


function get_appointment_details($conn,$doc_id,$pat_id,$pat_name,$date,$slot)
{
     $shift = (substr($slot,0,1)=='m')?0:1;
    $slot_no = substr($slot,2,strlen($slot));

    $query = ("SELECT user_name from tb_user where user_id = $doc_id");
    $result1 = $conn->query($query) or die ("result not properltys") ;
    $row1  = $result1->fetch_array();
    $doc_name=$row1["user_name"];
    $pat_name = $pat_name;

    //query to get appointment details
    $querytogetdetails=("SELECT * from appointment where doc_id = $doc_id  AND shift = $shift AND pat_id =$pat_id AND slot_no =$slot_no  AND date(appt_date) ='".$date."'");
    $resultofgetdetails=mysqli_query($conn,$querytogetdetails) or die ("Query to get data from first table failed: ".mysqli_error());
    $cdrowofdetails=mysqli_fetch_array($resultofgetdetails);
    $appt_id = $cdrowofdetails["apptt_id"];
    //$queue_no = $cdrowofdetails["queue_no"];
    $appt_date = (new DateTime($cdrowofdetails['appt_date']))->format('d-m-Y');
    $shift_name = ($shift == '0')?"Morning":"Evening";

    $ret = [];
    $ret['doc_name'] = $doc_name;
    $ret['pat_name'] = $pat_name;
    $ret['date'] = $date;
    return $ret;

}

    $doc_id = isset($_REQUEST['doc_id'])?$_REQUEST['doc_id']:null;
    $pat_id = isset($_REQUEST['pat_id'])?$_REQUEST['pat_id']:null;
    $date = isset($_REQUEST['date'])?$_REQUEST['date']:null;
    $slot = isset($_REQUEST['slot'])?$_REQUEST['slot']:null;
    $pat_name = isset($_REQUEST['pat_name'])?$_REQUEST['pat_name']:null;

    if(!($doc_id && $pat_id && $date && $slot))
        header("Location: index.php");

    $shift = (substr($slot,0,1)=='m')?0:1;
    $slot_no = substr($slot,2,strlen($slot));
    $q = "INSERT INTO appointment (doc_id, pat_id, appt_date, shift, slot_no, name,confirmed) 
    VALUES ($doc_id,$pat_id,'$date',$shift,$slot_no,'$pat_name',0)";
    if(!mysqli_query($conn,$q))
    {
        //        echo mysqli_error($conn);
    }

    else {
        $app_details = get_appointment_details($conn,$doc_id,$pat_id,$pat_name,$date,$slot); ?>

        <main>
<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-5">

                    <div class="modal-content">

                        <div class="modal-body">
                            <div class="container margin_120" style="margin-bottom: -5%;">
                                <div class="row justify-content-center text-center">
                                    <div class="col-lg-12">
                                        <div id="confirm">
                                            <div class="icon icon--order-success svg add_bottom_15" style="margin-top: -10%;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                            <h3 class="mb-1 mt-1">Thanks <b><i><?=$app_details['pat_name'] ?></i> </b> for booking appointment</h3>
                                            <h5 class="mb-1 mt-1"><i>Appointment Details</i></h5>
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-6 mt-3 mb-3">
                                            <table class="table table-striped table-responsive">
                                                <tbody>
                                                <tr>
                                                    <td><h5> <b style='color:black'> Dr Name </b> </h5></td>
                                                    <td><h5 style='color:black'> <i><?=$app_details['doc_name'] ?></i></h5></td>
                                                </tr>
                                                <tr>
                                                    <td><h5 style="color:black"> <b> Date </b> </h5></td>
                                                    <td><h5 style='color:black'> <i><?= $app_details['date']?></i></h5></td>
<!
                                                </tr>

                                                </tbody>
                                            </table>

                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <h4>You'll receive a confirmation of appointment soon </h4>
                                            <input class="btn-primary mt-3" type="button" name="home" value="Home" onclick="redirecttohome()">
                                        </div>

                                        <div class="row"></div>
                                    </div>
                                </div>
                                <!-- /row -->
                            </div>
                            <!-- /container -->
                        </div>


                </div>
        </div>
    </div>


</div>


        </main>




    <?php

    }

?>

<script>
    function redirecttohome() {
        window.location.href = './index.php';

    }
</script>
