<div class="table-responsive">
    <table class='table'>
        <tbody>
            <tr>
                <td colspan="5">
                    <h3>Unconfirmed Appointments</h3>
                </td>
            </tr>
            <tr>
                <th>Appt Id</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>&nbsp;</th>
            </tr>
            <?= list_appointments(0) ?>
            <tr>
                <td colspan="5">
                    <h3>Confirmed Appointments</h3>
                </td>
            </tr>
            <tr>
                <th>Appt Id</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th colspan="2">Time</th>
            </tr>
            <?= list_appointments(1) ?>
        </tbody>
    </table>
</div>

<?php


function list_appointments($confirmed)
{
    global $conn, $id;
    $q = "SELECT * FROM appointment WHERE doc_id = $id AND confirmed=$confirmed ORDER BY appt_date DESC";
    $r = mysqli_query($conn, $q);
    $d = mysqli_fetch_all($r, MYSQLI_ASSOC);

    if (sizeof($d) < 1 && $confirmed)
        return "<tr><td colspan='5'><b>No confirmed appointments</b></td></tr>";
    else if (sizeof($d) < 1 && !$confirmed)
        return "<tr><td colspan='5'><b>No un-confirmed appointments</b></td></tr>";


    $table = "";
    $schedule = get_schedule($id);


    $table = array_reduce($d, function ($t, $e) use ($id, $schedule) {
        $date = new DateTime($e['appt_date']);
        $weekday = $date->format("w");
        $confirmed = $e['confirmed'];
        $colspan = ($confirmed) ? "colspan='2'" : "";
        $appt_id = $e['id'];

        $actions = ($confirmed) ? "" : "<td>
                  <a class='btn btn-sm btn-danger' href='confirm_appointment.php?appt_id=$appt_id&confirmed=0'><span class='icon_close_alt2'></span></a>
                  <a href='confirm_appointment.php?appt_id=$appt_id&confirmed=1' class='btn btn-sm btn-success'><span class='icon_check_alt2'></span></a>
                </td>";


        $row = "<tr>
            <td>$appt_id</td>
            <td>$e[name]</td>
            <td>$e[appt_date]</td>
            <td $colspan >" . get_time($schedule[$weekday], $e['shift'], $e['slot_no']) . "</td>
            $actions
        </tr>\n";
        $t = $t . $row;
        return $t;
    }, "");


    return $table;
}

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

function get_schedule($id)
{
    global $conn;

    $q = "SELECT * FROM doc_schedule WHERE doc_id = $id";
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