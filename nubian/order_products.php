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
            ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                    <li class="active"> Order products</li>
                </ul>

                <hr class="soft"/>


                    <a href="order_history.php"class="btn btn-small btn-info">Go back</a>
                <input type='button' id='btn'  class="btn btn-small btn-danger"value='Print' onclick='printDiv();'>
                    <?php
                    $select="SELECT * FROM orders o INNER JOIN payment p on o.order_id = p.order_id
                     WHERE o.order_id='".$_GET['get']."'";
                    $rec=mysqli_query($con,$select);
                    $row=mysqli_fetch_array($rec);
                    ?>
                    <div id="DivIdToPrint">
                    <div class="span4">
                    <p><b>Order No</b> <?php echo $row['order_id']?> </p>
                    <p><b>Phone no</b>  <?php echo $row['phone_no']?> </p>
                    <p><b>Mpesa code</b> <?php echo $row['mpesa_code']?> </p>
                    <p><b>Amount</b> <?php echo number_format($ship=$row['payment_amount'])?> KSH </p>
                    <p><b>Order date</b> <?php echo$row['order_date']?> </p>
                    <p><b>Status</b> <?php echo$row['order_status']?> </p>
                </div>

                <table class="table table-bordered">
                    <thead>

                    <th>Product </th>
                    <th> Price Ksh</th>
                    <th> Quantity</th>
                    <th>Subtotal Ksh</th>
                    </thead>
                    <tbody>
                    <?php
                    $select = "SELECT * FROM order_items inner join product p on order_items.product_id = p.product_id
                   where order_items.order_id='".$_GET['get']."'AND cust_id='".$_SESSION['nID']."'";
                    $record = mysqli_query($con, $select);
                    while($row = mysqli_fetch_array($record)){
                        ?>
                        <tr>

                            <td><?php echo $row['product_name']?> </td>
                            <td><?php echo number_format($row['price'])?> </td>
                            <td><?php echo $row['item_quantity']?>  </td>
                            <td><?php echo number_format($row['price']*$row['item_quantity'])?>

                            </td>

                        </tr>
                        <?php
                        $total+=$row['price']*$row['item_quantity'];


                    }
                    ?>
                    <tr style="font-size: 1.5em;font-weight: bolder;text-align: center">
                        <td colspan="3">Item cost</td>
                        <td>
                            <?php
                            echo number_format($total);
                            ?>
                        </td>
                    </tr>
                    <tr style="font-size: 1.5em;font-weight: bolder;text-align: center">
                        <td colspan="3">Shipping cost</td>
                        <td>
                            <?php
                            echo number_format($ship-$total);
                            ?>
                        </td>
                    </tr>
                    <tr style="font-size: 1.5em;font-weight: bolder;text-align: center">
                        <td colspan="3">Total cost</td>
                        <td style="color: darkred">
                            <?php
                            echo number_format($ship);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>



            </div>
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="themes/js/jquery.js" type="text/javascript"></script>
<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
<script src="themes/js/google-code-prettify/prettify.js"></script>

<script src="themes/js/bootshop.js"></script>
<script src="themes/js/jquery.lightbox-0.5.js"></script>

<script>
    function printDiv()
    {

        var divToPrint=document.getElementById('DivIdToPrint');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    }
</script>
</body>
</html>