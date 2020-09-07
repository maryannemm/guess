<?php
error_reporting(E_ERROR);
session_start();

include 'php_files/config.php';

include 'cart_action.php';
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

            if($swal=='error'){
                echo'<script>
swal("Failed","'.$fb.'","error")
</script>';
            }
            if($swal=='success'){
                echo'<script>
swal("SUCCESS","'.$fb.'","success")
</script>';
            }
            ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                    <li class="active"> SHOPPING CART</li>
                </ul>
                <h3>  SHOPPING CART [ <small><?php echo $cart?> Item(s) </small>]
                    <a href="index.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
                <hr class="soft"/>


                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity/Update</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select="SELECT * FROM product p INNER JOIN order_items oi on p.product_id = oi.product_id
                     WHERE item_status='Cart' AND cust_id='".$_SESSION['nID']."'";
                    $rec=mysqli_query($con,$select);
                    while($row=mysqli_fetch_array($rec)){
                        ?>
                        <tr>
                            <td> <img width="60" src="uploads/<?php echo $row['image']?>" alt=""/></td>
                            <td><?php echo $row['product_name']?></td>
                            <td>
                                <div class="input-append">
                                    <form method="post"autocomplete="off">
                                        <input type="hidden" value="<?php echo $row['product_id']?>"name="hID">
                                        <input type="hidden" value="<?php echo $row['item_id']?>"name="itemID">
                                    <input class="span1"name="qty"min="1" style="max-width:34px"value="<?php echo $row['item_quantity']?>" placeholder="1" id="appendedInputButtons" size="16" type="text">
                                    <button class="btn"name="updateBtn" type="submit"><i class="icon-refresh"></i></button>
                                    <button class="btn btn-danger"name="removeBtn" type="submit"><i class="icon-remove icon-white"></i></button>				</div>
                                </form>
                            </td>
                            <td>Ksh<?php echo number_format($row['price'])?></td>
                            <td>Ksh<?php echo number_format($sub=$row['price']*$row['item_quantity'])?></td>

                        </tr>
                    <?php
                        $total+=$sub;
                    }
                    ?>

                    <tr>
                        <td colspan="4" style="text-align:right"><strong>TOTAL</strong></td>
                        <td class="label label-important" style="display:block"> <strong>Ksh <?php echo number_format($total)?></strong></td>
                    </tr>
                    </tbody>
                </table>
                <h3>
                    <a href="checkout.php" class="btn btn-primary btn-large pull-right">Go to checkout <i class="icon-arrow-right"></i>  </a>

                <a href="index.php" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
                </h3>
            </div>
        </div></div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<div  id="footerSection">
    <div class="container">
        <div class="row">
            <div class="span3">
                <h5>ACCOUNT</h5>
                <a href="login.html">YOUR ACCOUNT</a>
                <a href="login.html">PERSONAL INFORMATION</a>
                <a href="login.html">ADDRESSES</a>
                <a href="login.html">DISCOUNT</a>
                <a href="login.html">ORDER HISTORY</a>
            </div>
            <div class="span3">
                <h5>INFORMATION</h5>
                <a href="contact.html">CONTACT</a>
                <a href="register.html">REGISTRATION</a>
                <a href="legal_notice.html">LEGAL NOTICE</a>
                <a href="tac.html">TERMS AND CONDITIONS</a>
                <a href="faq.html">FAQ</a>
            </div>
            <div class="span3">
                <h5>OUR OFFERS</h5>
                <a href="#">NEW PRODUCTS</a>
                <a href="#">TOP SELLERS</a>
                <a href="special_offer.html">SPECIAL OFFERS</a>
                <a href="#">MANUFACTURERS</a>
                <a href="#">SUPPLIERS</a>
            </div>
            <div id="socialMedia" class="span3 pull-right">
                <h5>SOCIAL MEDIA </h5>
                <a href="#"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>
                <a href="#"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>
                <a href="#"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>
            </div>
        </div>
        <p class="pull-right">&copy; Bootshop</p>
    </div><!-- Container End -->
</div>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="themes/js/jquery.js" type="text/javascript"></script>
<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
<script src="themes/js/google-code-prettify/prettify.js"></script>

<script src="themes/js/bootshop.js"></script>
<script src="themes/js/jquery.lightbox-0.5.js"></script>


</body>
</html>