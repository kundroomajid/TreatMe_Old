<pre>
<?php
include_once('config.php');
$doc_id = 33;

$q = "SELECT * FROM appointment WHERE doc_id = $doc_id ORDER BY confirmed ASC";
$r = mysqli_query($conn, $q);
$d = mysqli_fetch_all($r, MYSQLI_ASSOC);
$table = "";
print_r($d);
$schedule = get_schedule($doc_id);
$table = array_reduce($d, function ($t, $e) use ($doc_id, $schedule) {
    $date = new DateTime($e['appt_date']);
    $weekday = $date->format("w");
    $row = "<tr>
        <td>$e[id]</td>
        <td>$e[name]</td>
        <td>$e[appt_date]</td>
        <td>" . get_time($schedule[$weekday], $e['shift'], $e['slot_no']) . "</td>
        <td>$e[confirmed]</td>
    </tr>\n";
    $t = $t . $row;
    return $t;
}, "");


echo "table: \n <table border='1'>".$table."</table>";

function get_time($schedule, $shift, $slot_no)
{
    $slot_no--;
    if ($shift)
        $start = strtotime($schedule['evening_start']);
    else
        $start = strtotime($schedule['morning_start']);

    $start = $start + ($slot_no * 30 * 60);
    return date('h:i:s A', $start);
}

function get_schedule($doc_id)
{
    global $conn;

    $q = "SELECT * FROM doc_schedule WHERE doc_id = $doc_id";
    if ($r = mysqli_query($conn, $q)) {
        $d = mysqli_fetch_all($r, MYSQLI_ASSOC);
        $schedule = array_reduce($d, function ($t, $e) {
            $t[$e['week']] = array(
                'morning_start' => $e['morning_start'],
                'morning_end' => $e['morning_end'],
                'evening_start' => $e['evening_start'],
                'evening_end' => $e['evening_end'],
                'num_patients' => $e['num_patients']
            );
            return $t;
        }, array());
        return $schedule;
    }
    return null;
}

?>