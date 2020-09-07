<?php
error_reporting(E_ERROR);
session_start();

include 'php_files/config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $siteName?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
    <!-- Bootstrap style responsive -->
    <link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>
    <script src="bootstrap/js/custom-sweetalert.js"></script>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</head>
<body>

<!-- Header ====================================================================== -->
<?php
include 'php_files/nav_bar.php';
?>
<!-- Header End====================================================================== -->
<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php
            include 'php_files/account_nav.php';


            if($swal=='success'){
                echo'<script>
swal("SUCCESS","'.$fb.'","success")
</script>';
            }

            if(!empty($_SESSION['success'])){
                echo'<script>
swal("SUCCESS","'.$_SESSION['success'].'","success")
</script>';
            }
            ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                    <li class="active"> Order history</li>
                </ul>

                <hr class="soft"/>

                <?php
                if(!empty($_SESSION['success'])){
                    ?>
                <div class="alert alert-success text-center text-capitalize">
                    <?php
                    echo $_SESSION['success'];
                    $_SESSION['success']='';
                    ?>

                </div>
                <?php
                }
                ?>



                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order number</th>
                        <th>Amount</th>
                        <th>Mpesa code</th>
                        <th>Order date</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select="SELECT * FROM orders o INNER JOIN payment p on o.order_id = p.order_id
                     WHERE o.cust_id='".$_SESSION['nID']."' ORDER BY p.payment_id DESC";
                    $rec=mysqli_query($con,$select);
                    while($row=mysqli_fetch_array($rec)){
                        ?>
                        <tr>

                            <td><?php echo $row['order_id']?></td>
                            <td style="text-align: center">Ksh <?php echo number_format($row['payment_amount'])?></td>
                            <td><?php echo $row['mpesa_code']?></td>
                            <td><?php echo $row['order_date']?></td>
                            <td><?php echo $row['order_status']?></td>
                            <td><a href="order_products.php?get=<?php echo $row['order_id']?>"class="btn btn-small btn-inverse">Items</a> </td>


                        </tr>
                    <?php

                    }
                    ?>

                    </tbody>
                </table>



            </div>
        </div></div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="themes/js/jquery.js" type="text/javascript"></script>
<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
<script src="themes/js/google-code-prettify/prettify.js"></script>

<script src="themes/js/bootshop.js"></script>
<script src="themes/js/jquery.lightbox-0.5.js"></script>


</body>
</html>