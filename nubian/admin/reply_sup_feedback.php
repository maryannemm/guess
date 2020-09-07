<?php
error_reporting(E_ERROR);
session_start();

ob_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";

if(isset($_POST['replyBtn'])) {


    $reply = $_POST['reply'];


    if (empty($reply)) {
        $swal = "error";
        $fb = "Write a reply";
    } else {

        $update = "UPDATE feedback_supplier SET reply='$reply' WHERE fd_id='" . $_GET['get'] . "'";
        if ($query = mysqli_query($con, $update)) {
            $swal = "success";
            $_SESSION['action'] = "Reply sent successfully";
            header('location:new_sup_feedback.php');

        } else {
            $swal = "error";
            $fb = "Filed to activate. Please try again";
        }
    }
}


ob_end_flush();
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
    <style>
        * {
            box-sizing: border-box;
        }

        #myInput {

            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: auto;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th, #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body class="index-body">
<noscript>
    <div id="testJs" class="test-tips">

    </div>
</noscript>
<div id="main_content" class="none" style="display: block;">
    <!------------header------------->
    <?php
   if($_SESSION['user']=='Admin'){
    include '../php_files/admin_topbar.php';
    
}else{
    include '../php_files/user_topbar.php';
}
    if($swal=='error'){
        echo'<script>
swal("Failed","'.$fb.'","error")
</script>';
    }
    if($swal=='success'){
        echo'<script>
swal("","'.$fb.'","success")
</script>';
    }
   if(!empty($_SESSION['success'])){
        echo'<script>
swal("","'.$_SESSION['success'].'","success")
</script>';
       $_SESSION['success']='';
    }

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
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: auto; height: auto;">

                <div class="col-md-1"><a href="new_cust_feedback.php"class="btn btn-danger btn-sm">Go back</a> </div>

                <div class="col-md-3 col-md-offset-1">
                    <form method="post"autocomplete="off">
                        <label>Please write a reply here</label>
                        <textarea class="form-control" name="reply"required></textarea>
                        <br>
                        <button class="btn btn-danger form-control"name="replyBtn">Reply</button>
                    </form>
                </div>
            </article>
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: auto; height: auto;">



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Manage customer account</h2>
                        <fieldset class="">

                                                       <div class="table-responsive form-group col-md-12">

                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                   <thead>

                                   <th>#</th>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Contact</th>
                                   <th>Comment</th>
                                   </thead>


                                   <?php
                                   $select="SELECT * FROM feedback_supplier f INNER JOIN  suppliers c ON f.supplier_id = c.supplier_id WHERE fd_id='".$_GET['get']."' ";
                                   $query=mysqli_query($con,$select);
                                   while ($row=mysqli_fetch_array($query)) {

                                       ?>
                                       <tr class="header">

                                           <td><?php echo $row['fd_id'] ?></td>
                                           <td><?php echo $row['supplier_name'] ?></td>
                                           <td><?php echo $row['username'] ?></td>
                                           <td><?php echo $row['email'] ?></td>
                                           <td><?php echo $row['phone_no'] ?></td>
                                           <td><?php echo $row['comment'] ?></td>

                                       </tr>
                                       <?php
                                   }
                                   ?>


                               </table>

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


    $(document).ready(function () {

        var datatable = $('#dataTables-example').dataTable(


        );

    });
</script>
               </body></html>