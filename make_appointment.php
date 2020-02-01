<?php
include_once('header.php');
    include_once('config.php');
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

    else {?>
        <script>
            $(document).ready(function(){
                $("#myModal").modal('show');
            });
        </script>
        <main>
            <div id="breadcrumb">
                <div class="container">
                </div>
            </div>
            <!-- /breadcrumb -->


        </main>




    <?php

    }

?>
<!-- Modal -->
<div id="myModal" class="modal fade " role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"></h6>
                <button type="button" class="close" data-dismiss="modal" onclick="redirecttohome()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container margin_120" style="margin-bottom: -5%;">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-12">
                            <div id="confirm">
                                <div class="icon icon--order-success svg add_bottom_15">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                        <g fill="none" stroke="#8EC343" stroke-width="2">
                                            <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                            <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                        </g>
                                    </svg>
                                </div>
                                <h3>Thanks for booking appointment</h3>
                                <h4>You'll receive a confirmation of appointment soon </h4>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="redirecttohome()">Close</button>
            </div>
        </div>

    </div>
</div>

<script>
    function redirecttohome() {
        window.location.href = './index.php';

    }
</script>
