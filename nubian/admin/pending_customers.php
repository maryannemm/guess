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

        include '../php_files/admin_topbar.php';



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
   if(!empty($_SESSION['action'])){
        echo'<script>
swal("","'.$_SESSION['action'].'","success")
</script>';
       $_SESSION['action']='';
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

            <div class="col-md-6 col-md-offset-4">
                <a href="approved_customers.php" class="btn btn-sm btn-success">Approved customers</a>
                <a href="pending_customers.php" class="btn btn-sm btn-info">Pending customers</a>
                <a href="rejected_customers.php" class="btn btn-sm btn-danger">Rejected customers</a>
            </div>
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: auto; height: auto;">



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Customer account</h2>
                        <fieldset class="">

                                                       <div class="table-responsive form-group col-md-12">

                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                   <thead>
                                   <th>Action</th>
                                   <th>#</th>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Contact</th>
                                   <th>Status</th>
                                   <th>Date created</th>
                                   </thead>


                                   <?php
                                   $select="SELECT * FROM customer WHERE status='Pending' ";
                                   $query=mysqli_query($con,$select);
                                   while ($row=mysqli_fetch_array($query)) {

                                       ?>
                                       <tr class="header">
                                           <td>
                                             <a href="manage_customers.php?get=<?php echo $row['cust_id'] ?>" class="text-info">Manage</a>

                                           </td>
                                           <td><?php echo $row['cust_id'] ?></td>
                                           <td><?php echo $row['first_name'].' '. $row['last_name'] ?></td>
                                           <td><?php echo $row['username'] ?></td>
                                           <td><?php echo $row['email'] ?></td>
                                           <td><?php echo $row['phone_no'] ?></td>
                                           <td><?php echo $row['status'] ?></td>
                                           <td><?php echo $row['date_created'] ?></td>

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

<link href="../datatable/css/jquery.dataTables.css" rel="stylesheet" />
<link href="../datatable/css/buttons.dataTables.css" rel="stylesheet" />

<script src="../datatable/js/jquery.dataTables.min.js"></script>
<script src="../datatable/js/jszip.min.js"></script>
<script src="../datatable/js/dataTables.buttons.min.js"></script>
<script src="../datatable/js/pdfmake.min.js"></script>
<script src="../datatable/js/vfs_fonts.js"></script>
<script src="../datatable/js/buttons.html5.min.js"></script>


<script>

    $(document).ready(function () {

        var datatable = $('#example').dataTable(

            {
                "dom": 'lBfrtip',
                "buttons": [
                    {
                        extend: 'pdf',

                        footer: true,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7]
                        }
                    },

                ]

            }
        );

    });


</script>
               </body></html>