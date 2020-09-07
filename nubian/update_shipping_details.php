<?php
session_start();
ob_start();
error_reporting(E_ERROR);

include 'php_files/config.php';

if(empty($_SESSION['nID'])){
    header('location:login.php');
}

if(isset($_POST['updateBtn'])){
    $company=$_POST['company'];
    $address=$_POST['address'];
    $city=$_POST['city'];

    if(empty($company)||empty($address)||empty($city)){
        $swal='error';
        $fb='no enter fields allowed';
    }else{
        $select="SELECT * FROM shipping_company WHERE comp_name='$company'";
        $query=mysqli_query($con,$select);
        $row=mysqli_fetch_array($query);
        $compID=$row['company_id'];

        $update="UPDATE shipping_details SET comp_id='$compID' , address='$address', city='$city' 
           WHERE cust_id='".$_SESSION['nID']."'";
        if(mysqli_query($con,$update)){
            $swal='success';
            $_SESSION['success']='update successfully';

            header('location:shipping_details.php');
        }else{
            $swal='error';
            $fb='Please try again';
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
                    <li class="active">Update shipping details</li>
                </ul>

                <hr class="soft"/>


                <div class="span3 offset1 well">
                    <table class="table table-condensed">
                        <?php
                        $select="SELECT * FROM shipping_company sc INNER JOIN shipping_details sd on sc.company_id = sd.comp_id
                      WHERE cust_id='".$_SESSION['nID']."' ";
                        $query=mysqli_query($con,$select);
                        $row=mysqli_fetch_array($query);
                        ?>

                        <h5>Update shipping details</h5>
                        <hr>
                        <form method="post" class="form-horizontal" autocomplete="off">
                            <div class="control-group">
                                <label class="control-label" for="inputCountry">Shipping company </label>

                                <div class="controls">
                                    <select class="form-control"name="company" required>
                                        <option><?php echo $row['comp_name']?></option>
                                        <?php
                                        $sel="SELECT * FROM shipping_company WHERE comp_name='".$row['comp_name']."'";
                                        $query=mysqli_query($con,$sel);
                                        while($rowQ=mysqli_fetch_array($query)){
                                            ?>
                                            <option><?php echo $rowQ['comp_name']?></option>
                                            <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputPost">City/town</label>
                                <div class="controls">
                                    <input type="text"name="city"value="<?php echo $row['city']?>" id="inputPost" placeholder="City/town" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputCountry">Address </label>
                                <div class="controls">
                                    <input type="text"name="address"value="<?php echo $row['address']?>" id="inputCountry" placeholder="Address" required>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit"name="updateBtn" class="btn btn-danger">Update </button>
                                </div>
                            </div>
                        </form>

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