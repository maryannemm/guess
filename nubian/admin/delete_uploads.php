<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['token'])){
    header('location:../');
}
include "../../php_files/config.php";

?>

<!DOCTYPE html>

<html lang="en" class=" lang-en" style="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="renderer" content="webkit"><meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $siteName?></title>

    <link rel="stylesheet" href="css_file/reasyui.css">
    <link rel="stylesheet" href="css_file/index.css">

    <![endif]-->
    <script src="js/b28n.js"></script>
    <script src="js/custom-sweetalert.js"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>
<body class="index-body">
<noscript>
    <div id="testJs" class="test-tips">

    </div>
</noscript>
<div id="main_content" class="none" style="display: block;">
    <!------------header------------->
    <?php
    include '../../php_files/admin_topbar.php';



    ?>
    <!----------/header--------------->

    <section class="container">
        <div class="row main-container">
            <!--------Left navbar----------------->
            <div class="navbar navbar-default col-sm-3 col-lg-2" id="nav">
                <?php
                include '../../php_files/admin_left_bar.php';
                ?>
            </div>
            <!--------Left navbar ----------------->
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: 1164px; height: 1154px;">



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Journals</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-5">
                                <?php

                                $select="SELECT * FROM journals j INNER JOIN uploads u ON j.journal_id = u.journal_id
                                    WHERE j_code='".$_GET['get']."'";
                                $query=mysqli_query($con,$select);
                                $row=mysqli_fetch_array($query);

                                ?>
                                        <form method="POST"  id="fupForm">
                                            <input type="hidden"class="form-control" name="hiddenID"value="<?php echo $row['id']?>" required>
                                            <input type="hidden"class="form-control" name="pdf"value="<?php echo $row['file_name']?>" required>
                                            <label>Journal category</label>
                                            <input type="text"class="form-control" name="journal"value="<?php echo $row['journal']?>" required>
                                            <label>Paper Title/Topic</label>
                                            <input type="text"class="form-control" name="title"value="<?php echo $row['title']?>" required>
                                        <br>
                                            <button type="submit" class="btn btn-sm btn-info submitBtn">Delete</button>

                                            <div class="gif-load" style="margin-left:30px; display:none;">
                                                <img src="//www.willmaster.com/images/preload.gif" alt="loading..."> Please wait
                                            </div>
                                        </form>


                            </div>

                            <div class="table-responsive form-group col-md-12">


                            </div>

                        </fieldset>

                    <hr>
                    <hr>
                    <hr>


            </div>

                </article>
        </div>
    </section>
</div>
<script src="js/index.js.js"></script>
<script src="js/jquery-1.12.4.min"></script>
<script src="js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#fupForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../php_code/remove_upload.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");// disable the button
                    $('.submitBtn').css("display","none");// hide the button
                    $('.backBtn').css("display","none");// hide the button
                    $('.gif-load').css("display","");// Show loading gif
                    $('#fupForm').css("opacity",".8");
                    swal("",'Submitting.......\nPlease wait');
                },
                success: function(response){ //console.log(response);
                    $('.statusMsg').html('');
                    if(response.status == 1){
                       $('#fupForm')[0].reset();
                        swal("Success",''+response.message+'',"success");
                        // $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }else{
                        swal("Error",''+response.message+'',"error");
                        // $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    $('#fupForm').css("opacity","");
                    $(".submitBtn").removeAttr("disabled"); // enable the button
                    $('.submitBtn').css("display",""); //display the button
                    $('.backBtn').css("display",""); //display the button
                    $('.gif-load').css("display","none"); //hide loading gif
                }
            });
        });
    });
</script>
               </body></html>