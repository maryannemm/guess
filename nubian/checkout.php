<?php
error_reporting(E_ERROR);
session_start();

include 'php_files/config.php';

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

if(isset($_POST['orderBtn'])){



    $phoneno=$_POST['phoneno'];
    $mpesacode=$_POST['mpesacode'];
    $cash=$_POST['cash'];

    if(empty($phoneno)|| empty($mpesacode)||empty($cash)){

        $swal='error';
        $fb= 'Please enter all  details';

    }elseif(!is_numeric($phoneno)){
        $swal='error';
        $fb= 'Invalid phone number';


    }elseif(strlen($phoneno)<>10){
        $swal='error';
        $fb= 'Phone number must have 10 digits';


    }elseif(strlen($mpesacode)<>10){
        $swal='error';
        $fb= 'Mpesa code should have 10 characters';
    }elseif(!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $mpesacode)){
        $swal='error';
        $fb='Mpesa code should contain Both letters and digits';
    }else{

        // get order id
        $slect="SELECT order_id FROM orders WHERE order_status='Cart'AND cust_id='".$_SESSION['nID']."'";
        $query=mysqli_query($con,$slect);
        $ro=mysqli_fetch_array($query);

        $orderID=$ro['order_id'];

        $insert="INSERT INTO payment(cust_id,order_id,phone_no,mpesa_code,payment_amount)VALUES
		('".$_SESSION['nID']."','$orderID','$phoneno','$mpesacode','$cash')";
        if(mysqli_query($con,$insert)){

            $i=0;
            foreach((array)$_POST as $val) {
                $hProID=$_POST['hProID'][$i];
                $hqty=$_POST['hqty'][$i];

                $updateStock="UPDATE product SET stock =stock-'$hqty' WHERE product_id='$hProID'";
                mysqli_query($con,$updateStock);
                $i++;

            }

            // get shipping details

            $slect="SELECT comp_id, address, city FROM shipping_details WHERE cust_id='".$_SESSION['nID']."'";
            $query=mysqli_query($con,$slect);
            $rowD=mysqli_fetch_array($query);

            $address=$rowD['address'];
            $city=$rowD['city'];
            $compID=$rowD['comp_id'];


            $update="UPDATE orders SET  order_date=CURRENT_TIMESTAMP,order_status='Pending approval',
           address='$address',city='$city',company_id='$compID'
            WHERE order_id='$orderID'";
            mysqli_query($con,$update);

            $up="UPDATE order_items SET item_status='Submitted' WHERE order_id='$orderID'";
            mysqli_query($con,$up);

            $_SESSION['success']='Order submitted. Your order number is '.$orderID;

            header('location:order_history.php');

        }else{

            $swal='error';
            $fb= 'Something went wrong please try again';

        }
    }
}
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
//            include 'php_files/sidebar.php';

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
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <ul class="breadcrumb">
                    <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                    <li class="active"> Checkout</li>
                </ul>
                <h3>  CHECKOUT [ <small><?php echo $cart?> Item(s) </small>]
                    <a href="cart.php" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Back to cart </a></h3>
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
                     WHERE item_status='Cart'AND cust_id='".$_SESSION['nID']."'";
                    $rec=mysqli_query($con,$select);
                    while($row=mysqli_fetch_array($rec)){
                        ?>
                        <tr>
                            <td> <img width="60" src="uploads/<?php echo $row['image']?>" alt=""/></td>
                            <td><?php echo $row['product_name']?></td>
                            <td style="text-align: center"><?php echo $row['item_quantity']?></td>
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

                <div  class=" table-bordered">



                        <div class="span4">
                            <?php
                            $sel="SELECT *FROM shipping_details sd INNER JOIN shipping_company sc on sd.comp_id = sc.company_id
                              WHERE sd.cust_id='".$_SESSION['nID']."'";
                            $qry=mysqli_query($con,$sel);
                            if($shipD=mysqli_num_rows($qry)<1){
                                ?>
                                <h4 class="text-warning">Shipping details missing </h4>
                                <small>Please enter shipping details below</small>
                                <form method="post" class="form-horizontal" autocomplete="off">
                                    <div class="control-group">
                                        <label class="control-label" for="inputCountry">Shipping company </label>

                                        <div class="controls">
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
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputPost">City/town</label>
                                        <div class="controls">
                                            <input type="text"name="city"value="<?php echo $city?>" id="inputPost" placeholder="City/town" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="inputCountry">Address </label>
                                        <div class="controls">
                                            <input type="text"name="address"value="<?php echo $address?>" id="inputCountry" placeholder="Address" required>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="submit"name="submitBtn" class="btn btn-danger">Submit </button>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            }else{
                                $rowS=mysqli_fetch_array($qry);

                                ?>
                                <h3 class="">Shipping details</h3>
                                <table class="table table-bordered">
                                    <tr><td><b>Shipping company </b></td> <td><?php echo $rowS['comp_name']?></td></tr>
                                    <tr><td><b>Shipping cost </b></td> <td><?php echo number_format($rowS['shipping_cost'])?> Ksh</td></tr>
                                    <tr><td><b>Address </b></td> <td><?php echo $rowS['address']?></td></tr>
                                    <tr><td><b>City </b></td> <td><?php echo $rowS['city']?></td></tr>
                                    <tr><td colspan="2">
                                            <a href="update_shipping_details.php"class="btn btn-inverse">Update</a>
                                        </td></tr>
                                </table>
                            <?php
                            }
                            ?>



                        </div>
                        <div class="span3">
                            <h3 class="alignR">Make payment </h3>
                            <div class="alignR" >
                                <p><b>Cost</b> <?php echo number_format($total)?> Ksh</p>

                                <p><b>Shipping</b> <?php echo number_format($rowS['shipping_cost'])?> Ksh</p>
                                <p><b>Total cost</b> <?php echo number_format($rowS['shipping_cost']+$total)?> Ksh</p>
                            </div>

                            <form method="post" class="form-horizontal" autocomplete="off">
                                <?php
                                echo $fb;
                                ?>

                                <table>
                                    <?php
                                    $select="SELECT * FROM order_items WHERE item_status='Cart'
                            AND cust_id='".$_SESSION['nID']."'";
                                    $qry=mysqli_query($con,$select);
                                    while($row=mysqli_fetch_array($qry)){
                                        ?>
                                        <tr>
                                            <td><input type="hidden"name="hProID[]" value="<?php echo $row['product_id']?>"> </td>
                                            <td><input type="hidden"name="hqty[]" value="<?php echo $row['item_quantity']?>"> </td>
                                            <td><?php echo $row['']?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                                <div class="control-group">
                                    <label class="control-label" for="inputCountry">Phone number </label>
                                    <div class="controls">
                                        <input type="text"name="phoneno" id="inputCountry"value="<?php echo $_SESSION['pNo']?>" placeholder="Phone number" readonly>
                                    </div>
                                    </div>
                                <div class="control-group">
                                  <label class="control-label" for="inputCountry">Mpesa code </label>
                                    <div class="controls">
                                        <input type="text"name="mpesacode" id="inputCountry"value="<?php echo $mpesacode?>" placeholder="Mpesa code" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="inputPost">Amount</label>
                                    <div class="controls">
                                        <input type="text" name="cash" id="inputPost"value="<?php echo $rowS['shipping_cost']+$total?>" placeholder="Amount" readonly>
                                        <br>
                                        <br>
                                        <?php
                                        if($shipD<1){
                                            ?>
                                            <button type="submit"name="orderBtn" class="btn btn-primary">Order </button>
                                        <?php
                                        }else{
                                            ?>
                                            <button type="button" class="btn btn-primary" onclick="swal('','Shipping details missing!! \n Please enter your shipping details to continue','')">Order </button>
                                        <?php


                                        }
                                        ?>

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