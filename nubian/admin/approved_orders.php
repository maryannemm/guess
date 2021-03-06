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

            <div class="col-md-6 col-md-offset-4">
                <?php
                if($_SESSION['user']=='Procurement'){
                    ?>

                <?php
                }else{
                    ?>
                    <a href="approved_orders.php" class="btn btn-sm btn-success">Approved orders</a>
                    <a href="pending_orders.php" class="btn btn-sm btn-info">Pending orders</a>
                    <a href="rejected_orders.php" class="btn btn-sm btn-danger">Rejected orders</a>
                <?php
                }
                ?>

            </div>
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: auto; height: auto;">



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Approved orders</h2>
                        <fieldset class="">

                                                       <div class="table-responsive form-group col-md-12">

                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                   <thead>
                                   <th>Action</th>
                                   <th>#</th>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Amount</th>
                                   <th>Mpesa code</th>
                                   <th>Order date</th>
                                   <th>Status</th>
                                   </thead>


                                   <?php
                                   $select="SELECT * FROM customer c INNER JOIN orders o On c.cust_id = o.cust_id
                                             RIGHT JOIN payment p ON o.order_id = p.order_id WHERE o.order_status='Approved' ";
                                   $query=mysqli_query($con,$select);
                                   while ($row=mysqli_fetch_array($query)) {

                                       ?>
                                       <tr class="header">
                                           <td>
                                             <a href="order_details.php?get=<?php echo $row['order_id'] ?>" class="text-info">Details</a>

                                           </td>
                                           <td><?php echo $row['order_id'] ?></td>
                                           <td><?php echo $row['first_name'].' '. $row['last_name'] ?></td>
                                           <td><?php echo $row['username'] ?></td>
                                           <td><?php echo $row['payment_amount'] ?></td>
                                           <td><?php echo $row['mpesa_code'] ?></td>
                                           <td><?php echo $row['order_date'] ?></td>
                                           <td><?php echo $row['order_status'] ?></td>

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