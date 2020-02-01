<table>
    <input type="hidden" id="doc_id" value="<?= $id; ?>">
    <tr>
        <th>Day</th>
        <th>Morning Start</th>
        <th>Morning End</th>
        <th>Evening Start</th>
        <th>Evening End</th>
        <th>Action</th>
        <th>Status</th>
    </tr>

    <tr>
        <td>Sunday</td>
        <td><input type="time" min="00:00" max="11:59" step="1800" name="mstart_1" id="mstart_1" /></td>
        <td><input type="time" min="00:00" max="11:59" step="1800" name="mend_1" id="mend_1" /></td>
        <td><input type="time" min="12:00" max="23:59" step="1800" name="estart_1" id="estart_1" /></td>
        <td><input type="time" min="12:00" max="23:59" step="1800" name="eend_1" id="eend_1" /></td>
        <td><input type="button" value="Save" name="1" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Monday</td>
        <td><input type="time" name="mstart_2" id="mstart_2" /></td>
        <td><input type="time" name="mend_2" id="mend_2" /></td>
        <td><input type="time" name="estart_2" id="estart_2" /></td>
        <td><input type="time" name="eend_2" id="eend_2" /></td>
        <td><input type="button" value="Save" name="2" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Tuesday</td>
        <td><input type="time" name="mstart_3" id="mstart_3" /></td>
        <td><input type="time" name="mend_3" id="mend_3" /></td>
        <td><input type="time" name="estart_3" id="estart_3" /></td>
        <td><input type="time" name="eend_3" id="eend_3" /></td>
        <td><input type="button" value="Save" name="3" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Wednesday</td>
        <td><input type="time" name="mstart_4" id="mstart_4" /></td>
        <td><input type="time" name="mend_4" id="mend_4" /></td>
        <td><input type="time" name="estart_4" id="estart_4" /></td>
        <td><input type="time" name="eend_4" id="eend_4" /></td>
        <td><input type="button" value="Save" name="4" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>


    <tr>
        <td>Thursday</td>
        <td><input type="time" name="mstart_5" id="mstart_5" /></td>
        <td><input type="time" name="mend_5" id="mend_5" /></td>
        <td><input type="time" name="estart_5" id="estart_5" /></td>
        <td><input type="time" name="eend_5" id="eend_5" /></td>
        <td><input type="button" value="Save" name="5" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Friday</td>
        <td><input type="time" name="mstart_6" id="mstart_6" /></td>
        <td><input type="time" name="mend_6" id="mend_6" /></td>
        <td><input type="time" name="estart_6" id="estart_6" /></td>
        <td><input type="time" name="eend_6" id="eend_6" /></td>
        <td><input type="button" value="Save" name="6" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td>Saturday</td>
        <td><input type="time" name="mstart_7" id="mstart_7" /></td>
        <td><input type="time" name="mend_7" id="mend_7" /></td>
        <td><input type="time" name="estart_7" id="estart_7" /></td>
        <td><input type="time" name="eend_7" id="eend_7" /></td>
        <td><input type="button" value="Save" name="7" onclick="save_schedule(this)"></td>
        <td>&nbsp;</td>
    </tr>
</table>

<script>
    function save_schedule(saveBtn) {
        var week = saveBtn.name;
        mstart = document.getElementById('mstart_' + week).value;
        mend = document.getElementById('mend_' + week).value;
        estart = document.getElementById('estart_' + week).value;
        eend = document.getElementById('eend_' + week).value;
        doc_id = document.getElementById('doc_id').value;
        action = 'save_schedule';
        mydata = {
            doc_id,
            week,
            mstart,
            mend,
            estart,
            eend,
            action
        }
        $.ajax({
            url: "save_schedule.php",
            data: mydata,
            success: function(d) {
                console.log(d);
            }
        });
    }
</script>