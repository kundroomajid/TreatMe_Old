<?php
// print_r($_REQUEST);

include_once('config.php');

$action = $_REQUEST['action'];
switch ($action) {
    case 'save_schedule':
        echo save_schedule();
        break;

    default:

        break;
}


function get_schedule($doc_id)
{ }

function save_schedule()
{
    global $conn;
    $str_mstart = ($_REQUEST['mstart']);
    $str_mend = ($_REQUEST['mend']);

    $str_estart = ($_REQUEST['estart']);
    $str_eend = ($_REQUEST['eend']);


    $mstart = strtotime($_REQUEST['mstart']);
    $mend = strtotime($_REQUEST['mend']);

    $estart = strtotime($_REQUEST['estart']);
    $eend = strtotime($_REQUEST['eend']);
    $doc_id = $_REQUEST['doc_id'];
    $week = $_REQUEST['week'];
    $num_patients = 3;


    $mtime = ($mend - $mstart) / 60;
    $etime = ($eend - $estart) / 60;

    if ($mtime < 30 || $etime < 30)
        return "Error";


    $q = "INSERT INTO doc_schedule (doc_id,week,morning_start,morning_end,evening_start,evening_end,num_patients) VALUES 
            ($doc_id,$week,'$str_mstart','$str_mend','$str_estart','$str_eend',$num_patients)";

    if (mysqli_query($conn, $q))
        return "success";
    else
        return mysqli_error($conn);
}
