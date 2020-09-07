<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
if(empty($_SESSION['hID'])){
  //  header('location:pending_customers.php');
}


include "../php_files/config.php";

if(isset($_POST['rejectBtn'])){

    $remarks=$_POST['remark'];

    if(empty($remarks)) {
        $swal="error";
        $fb="Please write a remark";
    }else{


    $update="UPDATE orders SET order_status='Rejected',order_remark='$remarks' WHERE order_id='".$_GET['get']."'";
    if($query=mysqli_query($con,$update)){
        $_SESSION['success']="Order rejected";

       header('location:pending_orders.php');
    }else{
        $swal="error";
        $fb="Filed to reject. Please try again";
    }
       }

   }

if(isset($_POST['approveBtn'])){

    $status=$_POST['status'];

    if(empty($status)) {
        $swal="error";
        $fb="Please select a status option";
    }else{


        $update="UPDATE orders SET order_status='Approved' WHERE order_id='".$_GET['get']."'";
        if($query=mysqli_query($con,$update)){
            $_SESSION['success']="Order approved";

            header('location:pending_orders.php');
        }else{
            $swal="error";
            $fb="Filed to reject. Please try again";
        }
    }

}
if(isset($_POST['shipBtn'])){

    $status=$_POST['status'];

    if(empty($status)) {
        $swal="error";
        $fb="Please select a status option";
    }else{


        $update="UPDATE orders SET order_status='Shipping' WHERE order_id='".$_GET['get']."'";
        if($query=mysqli_query($con,$update)){
            $_SESSION['success']="Order marked as shipping";

            header('location:approved_orders.php');
        }else{
            $swal="error";
            $fb="Filed to reject. Please try again";
        }
    }

}
if(isset($_POST['deliverBtn'])){

    $status=$_POST['status'];

    if(empty($status)) {
        $swal="error";
        $fb="Please select a status option";
    }else{


        $update="UPDATE orders SET order_status='Delivered',delivery_date=CURRENT_TIMESTAMP WHERE order_id='".$_GET['get']."'";
        if($query=mysqli_query($con,$update)){
            $_SESSION['success']="Order marked as delivered";

            header('location:shipping_orders.php');
        }else{
            $swal="error";
            $fb="Filed to reject. Please try again";
        }
    }

}

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



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Order details</h2>
                        <fieldset class="">

                                                       <div class="table-responsive form-group col-md-4">
                                                           <h3>Customer details</h3>
                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                   <?php
                                   $select="SELECT * FROM customer c INNER JOIN orders o on c.cust_id = o.cust_id
                                    RIGHT JOIN payment p ON o.order_id=p.order_id 
                                    RIGHT JOIN shipping_company sp ON o.company_id=sp.company_id WHERE o.order_id='".$_GET['get']."' ";
                                   $query=mysqli_query($con,$select);
                                  $row=mysqli_fetch_array($query);
                                   ?>

                                       <tr class="header">
                                       <tr><td><b>Name </b></td><td><?php echo $row['first_name'].' '. $row['last_name'] ?></td></tr>
                                       <tr><td><b>Username </b>   <td><?php echo $row['username'] ?></td></tr>
                                       <tr><td><b>Email </b>    <td><?php echo $row['email'] ?></td></tr>
                                       <tr><td><b>Phone number </b>    <td><?php echo $row['phone_no'] ?></td></tr>
                                       <tr><td><b>Date created </b>   <td><?php echo $row['date_created'] ?></td></tr>

                                      </table>

                            </div>
                            <div class="col-md-4">
                                <h3>Order details</h3>
                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                    <tr class="header">
                                    <tr><td><b>Order ID </b>   <td><?php echo $row['order_id'] ?></td></tr>
                                    <tr><td><b>Amount Ksh </b>    <td><?php echo number_format($row['payment_amount']) ?></td></tr>
                                    <tr><td><b>Mpesa code </b>    <td><?php echo $row['mpesa_code'] ?></td></tr>
                                    <tr><td><b>Order status </b>  <td><?php echo $row['order_status'] ?></td></tr>
                                    <tr><td><b>Order date </b>   <td><?php echo $row['order_date'] ?></td></tr>

                                </table>
                            </div>
                           <div class="col-md-4">
                                <h3>Shipping details</h3>
                                <table id="dataTables-example"class="table table-striped table-responsive tableData">

                                    <tr class="header">
                                    <tr><td><b>Shipping company </b>   <td><?php echo $row['comp_name'] ?></td></tr>
                                    <tr><td><b>Address </b>    <td><?php echo $row['address'] ?></td></tr>
                                    <tr><td><b>City / Town </b>  <td><?php echo $row['city'] ?></td></tr>
                                    <tr><td><b>Country </b>   <td>Kenya</td></tr>

                                </table>
                            </div>

                            <div class="col-md-12">
                                <h3>Order items </h3>
                                <table id="dataTables-example"class="table table-striped table-responsive tableData">
                                    <th>Item name</th>
                                    <th>Price Ksh</th>
                                    <th>Quantity</th>
                                    <th>Subtotal Ksh</th>
                                    <?php
                                    $select="SELECT * FROM product p INNER JOIN order_items oi on p.product_id = oi.product_id
                                     WHERE oi.order_id='".$_GET['get']."'";
                                    $query=mysqli_query($con,$select);
                                    while($rowS=mysqli_fetch_array($query)){
                                        echo '<tr>
                                                <td>'.$rowS['product_name'].'</td>
                                                <td>'.number_format($rowS['price']).'</td>
                                                <td>'.$rowS['item_quantity'].'</td>
                                                <td>'.number_format($rowS['price']*$rowS['item_quantity']).'</td>

                                        </tr>';
                                    }
                                    ?>

                                </table>

                            </div>

                            <?php




                                if ($row['order_status'] == 'Pending approval') {

                                    if($_SESSION['user']=='Cashier'){
                                        ?>
                                        <div class="col-md-3">
                                            <form method="post" autocomplete="off">
                                                <label>Approve order</label>

                                                <select class="form-control" required name="status">
                                                    <option></option>
                                                    <option>Approve</option>
                                                </select>
                                                <br>
                                                <input type="submit" class="form-control btn btn-success" value="Approve"
                                                       name="approveBtn">
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="post" autocomplete="off">
                                                <label>Writea remark why order is reject order</label>
                                                <textarea class="form-control" rows="4" name="remark" required></textarea>
                                                <br>
                                                <input type="submit" class="form-control btn btn-danger" value="Reject"
                                                       name="rejectBtn">
                                            </form>
                                        </div>

                                        <?php
                                    }
                                    ?>


                                    <?php
                                }
                            if($_SESSION['user']=='Procurement') {

                                if ($row['order_status'] == 'Approved') {
                                    ?>

                                    <div class="col-md-3">
                                        <form method="post" autocomplete="off">
                                            <label>Ship order</label>

                                            <select class="form-control" required name="status">
                                                <option></option>
                                                <option>Shipping order</option>
                                            </select>
                                            <br>
                                            <input type="submit" class="form-control btn btn-success" value="Ship order"
                                                   name="shipBtn">
                                        </form>
                                    </div>
                                    <?php
                                }


                                if ($row['order_status'] == 'Shipping') {
                                    ?>

                                    <div class="col-md-3">
                                        <form method="post" autocomplete="off">
                                            <label>Mark order as delivered</label>

                                            <select class="form-control" required name="status">
                                                <option></option>
                                                <option>Deliver order</option>
                                            </select>
                                            <br>
                                            <input type="submit" class="form-control btn btn-success"
                                                   value="Deliver order"
                                                   name="deliverBtn">
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

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