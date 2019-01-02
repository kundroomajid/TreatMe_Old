<?php include("header.php");
include("config.php");
?>

<html>
    <head>
     <title>Bootstrap datepicker example text input with specifying date format</title>
<!--     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  -->
        <link href = "./css/date_picker.css"/>

    <script src=./js/bootstrap-datepicker.js></script> 
    
    </head>
    <body> 
        <input  class="form-control" type="text" placeholder="click to show datepicker"  id="example1">
       
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#example1').datepicker({
                     autoclose: true,
                    format: "dd/mm/yyyy"
                });  
            
            });
        </script>
 </body>
 </html>