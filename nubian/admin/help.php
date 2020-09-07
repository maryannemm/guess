<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
   header('location:index.php');
}
include "../php_files/config.php";



?>

<!DOCTYPE html>

<html lang="en" class=" lang-en" style="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="renderer" content="webkit"><meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $siteName?></title>
    <link rel="shortcut icon" href="http://192.168.0.1/favicon.ico">
    <link rel="stylesheet" href="css_file/reasyui.css">
    <link rel="stylesheet" href="css_file/index.css">
    <link href="css_file/bootstrap.min.css">
    <![endif]-->

    <script src="js/b28n.js"></script>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>
<body class="index-body">
<noscript>
    <div id="testJs" class="test-tips">
        <p>Error! The browser does not support JavaScript. </p>
        <p>Please enable JavaScript or try another browser compatible with JavaScript to
			experience more features.
		</p>
    </div>
</noscript>
<div id="main_content" class="none" style="display: block;">
    <!------------header------------->
    <?php

    include '../php_files/admin_topbar.php';
    


    ?>
    <!----------/header--------------->

    <section class="container">
        <div class="row main-container">
            <!--------Left navbar----------------->
            <div class="navbar navbar-default col-sm-3 col-lg-2" id="nav">
                <?php
                include '../php_files/admin_left_bar.php';
                ?>
            </div>
            <!--------Left navbar ----------------->
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" >



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Journals</h2>
                        <fieldset class="" style="height: 1550px">


                            <div class="col-md-9 col-md-offset-1 ">
                                <hr>
                         <h4>Help</h4>
                                <ul>
                                    <li>log in to your account select which  customers you will approve or reject. </li>
                                    <li>Register the suppliers allowed to supply their goods to the firm. </li>
                                    <li>Register the employees working in the firm. </li>
                                    <li>Register the shipping companies that are available for the firm to use. </li>
                                  
                                </ul>
                            </div>
                        </fieldset>
                    <hr>







            </div>

                </article>
        </div>
    </section>
</div>

<script src="js/index.js.js"></script>
<script src="js/jquery-1.12.4.min"></script>
<script src="js/bootstrap.min.js"></script>
<script src="../dist/js/jquery.dcjqaccordion.2.7.js"></script>
<link type="text/css" rel="stylesheet" href="../../dist/dataTablesCustom/jquery.dataTables.css?"/>
<script src="../../dist/dataTablesCustom/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#fupForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../php_code/insert_journal.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");// disable the button
                    $('.submitBtn').css("display","none");// hide the button
                    $('.gif-load').css("display","");// Show loading gif
                    $('#fupForm').css("opacity",".8");
                    swal("",'Submitting.......\nPlease wait');
                },
                success: function(response){ //console.log(response);
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#fupForm')[0].reset();
                        swal("Success",''+response.message+'',"success");
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }else{
                        swal("Error",''+response.message+'',"error");
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    $('#fupForm').css("opacity","");
                    $(".submitBtn").removeAttr("disabled"); // enable the button
                    $('.submitBtn').css("display",""); //display the button
                    $('.gif-load').css("display","none"); //hide loading gif
                }
            });
        });
    });
</script>
<script>


    $(document).ready(function () {

        var datatable = $('#dataTables-example').dataTable(


        );

    });
</script>
               </body></html>