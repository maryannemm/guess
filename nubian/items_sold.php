<?php
session_start();
ob_start();
error_reporting(E_ERROR);

include 'php_files/config.php';

if(empty($_SESSION['sID'])){
    header('location:login.php');
}
   if(isset($_POST['submitBtn'])){
       $item=$_POST['item'];

       $select="SELECT * FROM product WHERE product_name='$item'";
       $query=mysqli_query($con,$select);
       $row=mysqli_fetch_array($query);
       $proID=$row['product_id'];

       $select="SELECT * FROM item_sold WHERE product_id='$proID' AND supplier_id='".$_SESSION['sID']."'";
       $query=mysqli_query($con,$select);
       if(mysqli_num_rows($query)>0){
           $swal='error';
           $fb='Product already added';

       }else{
           $insert="INSERT INTO item_sold (product_id, supplier_id) VALUES ('$proID','".$_SESSION['sID']."')";
           if(mysqli_query($con,$insert)){
               $swal='success';
               $fb='Product submitted successfully';
           }else{
               $swal='error';
               $fb='Something went wrong please try again';
           }
       }
   }


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
            include 'php_files/supplier_nav.php';


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

            if(!empty($_SESSION['success'])){
                echo'<script>
swal("","'.$_SESSION['success'].'","success")
</script>';
                $_SESSION['success']='';
            }
            ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                    <li class="active">Profile</li>
                </ul>

                <hr class="soft"/>


                <div class="span6 offset1 well">
                    <form method="post">
                        <select class=""name="item">
                            <option></option>
                            <?php
                            $select="SELECT * FROM product";
                            $query=mysqli_query($con,$select);
                            while($row=mysqli_fetch_array($query)){
                                ?>
                                <option><?php echo $row['product_name']?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <br>
                        <button class="btn btn-primary" type="submit"name="submitBtn">Submit</button>
                    </form>
                    <table class="table table-condensed">
                        <th>Product name</th>
                        <th>Date added</th>
                    <?php
                    $select="SELECT * FROM product p INNER JOIN item_sold i on p.product_id = i.product_id WHERE supplier_id='".$_SESSION['sID']."' ";
                    $query=mysqli_query($con,$select);
                    while($row=mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td><?php echo $row['product_name']?></td>
                            <td><?php echo $row['date_added']?></td>
                        </tr>
                        <?php
                    }
                    ?>



                    </table>

                    </div>
                </div>


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