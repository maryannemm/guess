<?php
session_start();
ob_start();
error_reporting(E_ERROR);

include 'php_files/config.php';


ob_end_flush();
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
          //  include 'php_files/sidebar.php';

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
                    <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                    <li class="active">Help</li>
                </ul>

                <hr class="soft"/>

                <div class="span4 offset1">
                 <h5>Help</h5>
                    <ul>
                        <li>for new customers, you have to register first and wait for administrator's approval then log in. </li>
                        <li> For already registered customers, log in after plentering your password and name. </li>
                        <li> click on add to cart, to add the product to your cart. </li>
                        <li>Click on 'items in your cart' at the top right corner . </li>
                        <li> Enter your shipping/billing information and make payment. Then proceed to checkout. </li>
                        <li>You will be notified once the goods arrive via the shipping company you selected </li>








                    </ul>

                </div>
                </div>


            </div>
        </div></div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<!--<div  id="footerSection">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="span3">-->
<!--                <h5>ACCOUNT</h5>-->
<!--                <a href="login.html">YOUR ACCOUNT</a>-->
<!--                <a href="login.html">PERSONAL INFORMATION</a>-->
<!--                <a href="login.html">ADDRESSES</a>-->
<!--                <a href="login.html">DISCOUNT</a>-->
<!--                <a href="login.html">ORDER HISTORY</a>-->
<!--            </div>-->
<!--            <div class="span3">-->
<!--                <h5>INFORMATION</h5>-->
<!--                <a href="contact.html">CONTACT</a>-->
<!--                <a href="register.html">REGISTRATION</a>-->
<!--                <a href="legal_notice.html">LEGAL NOTICE</a>-->
<!--                <a href="tac.html">TERMS AND CONDITIONS</a>-->
<!--                <a href="faq.html">FAQ</a>-->
<!--            </div>-->
<!--            <div class="span3">-->
<!--                <h5>OUR OFFERS</h5>-->
<!--                <a href="#">NEW PRODUCTS</a>-->
<!--                <a href="#">TOP SELLERS</a>-->
<!--                <a href="special_offer.html">SPECIAL OFFERS</a>-->
<!--                <a href="#">MANUFACTURERS</a>-->
<!--                <a href="#">SUPPLIERS</a>-->
<!--            </div>-->
<!--            <div id="socialMedia" class="span3 pull-right">-->
<!--                <h5>SOCIAL MEDIA </h5>-->
<!--                <a href="#"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>-->
<!--                <a href="#"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>-->
<!--                <a href="#"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <p class="pull-right">&copy; Bootshop</p>-->
<!--    </div>
</div>-->
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="themes/js/jquery.js" type="text/javascript"></script>
<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
<script src="themes/js/google-code-prettify/prettify.js"></script>

<script src="themes/js/bootshop.js"></script>
<script src="themes/js/jquery.lightbox-0.5.js"></script>




</body>
</html>