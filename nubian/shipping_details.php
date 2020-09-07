<?php
session_start();
ob_start();
error_reporting(E_ERROR);

include 'php_files/config.php';

if(empty($_SESSION['nID'])){
    header('location:login.php');
}
if(isset($_POST['submitBtn'])){
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

        $insert="INSERT INTO shipping_details(comp_id, cust_id, address, city) 
            VALUES ('$compID','".$_SESSION['nID']."','$address','$city')";
        if(mysqli_query($con,$insert)){
            $swal='success';
            $fb='Submitted successfully';
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
            include 'php_files/account_nav.php';


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
                    <li class="active">Shipping details</li>
                </ul>

                <hr class="soft"/>


                <div class="span4 offset1 well">

                    <?php
                    $select="SELECT * FROM shipping_company sc INNER JOIN shipping_details sd on sc.company_id = sd.comp_id
                      WHERE sd.cust_id=".$_SESSION['nID'];
                    $query=mysqli_query($con,$select);
                    if(mysqli_num_rows($query)>0){
                    $row=mysqli_fetch_array($query)
                        ?>
                        <table class="table table-condensed">
                            <tr class="header">
                            <tr><td><b>Company </b></td><td><?php echo $row['comp_name'] ?></td></tr>
                            <tr><td><b>Shipping cost Ksh </b>   <td><?php echo $row['shipping_cost'] ?></td></tr>
                            <tr><td><b>Address </b>    <td><?php echo $row['address'] ?></td></tr>
                            <tr><td><b>City / Town </b>    <td><?php echo $row['city'] ?></td></tr>

                            <tr><td colspan="2">
                                    <a href="update_shipping_details.php"class="btn  btn-primary">Update</a>
                                </td></tr>

                        </table>
                        <?php
                    }else{
                        ?>
                        <h4 class="text-warning">Shipping details missing </h4>
                        <small>Please enter shipping details below</small>
                        <form method="post" class="form-horizontal" autocomplete="off">
                            <div class="control-group">
                                <label class="control-label" for="inputCountry">Shipping company </label>


                                    <select class="form-control"name="company" required>
                                        <option><?php echo $company?></option>
                                        <?php
                                        $sel="SELECT * FROM shipping_company";
                                        $query=mysqli_query($con,$sel);
                                        while($rowQ=mysqli_fetch_array($query)){
                                            ?>
                                            <option><?php echo $rowQ['comp_name']?></option>
                                            <?php
                                        }

                                        ?>
                                    </select>

                            </div>
                            <div class="control-group">
                                <label class="control-label" for="inputPost">City/town</label>


                                    <input type="text"name="city"value="<?php echo $city?>" id="inputPost" placeholder="City/town" required>

                            </div>


                                <div class="controls-group">
                                    <label class="control-label" for="inputCountry">Address </label>
                                    <input type="text"name="address"value="<?php echo $address?>" id="inputCountry" placeholder="Address" required>
                                </div>


                            <div class="control-group">
                                    <button type="submit"name="submitBtn" class="btn btn-danger">Submit </button>
                                </div>
                            </div>
                        </form>
                    <?php
                    }
                    ?>



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