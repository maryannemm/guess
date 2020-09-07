<?php
session_start();
ob_start();
error_reporting(E_ERROR);

include 'php_files/config.php';


if(isset($_POST['loginBtn'])){

    $swal='error';
    $fb='Please enter a username and password';
    $username=$_POST['username'];
    $password=$_POST['password'];
    $loginAs=$_POST['loginAs'];


    if(empty($username)||empty($password)){

        $swal='error';
        $fb='Username and password required';

    }else {

        if ($loginAs=='Supplier'){
            $select = "SELECT * FROM suppliers WHERE username='$username' AND password='$password'";
            $record = mysqli_query($con, $select);
            if ($check = mysqli_num_rows($record) > 0) {
                $row = mysqli_fetch_array($record);

                if ($row['status'] == 'Blocked') {
                    $swal = 'error';
                    $fb = 'Access denied.';

                } elseif ($row['status'] == 'Pending') {
                    $swallnfo = 'error';
                    $fb = 'Account not yet activated.';

                } elseif ($row['status'] =='Approved') {

                    $_SESSION['sID']= $row['supplier_id'];
                    $_SESSION['suser']= $row['username'];

                    header('location:profile_supplier.php');

                } else {
                    $swal = 'error';
                    $fb = ' Invalid login details';
                }

            }
        }else{


        $select = "SELECT * FROM customer WHERE username='$username' AND password='$password'";
        $record = mysqli_query($con, $select);
        if ($check = mysqli_num_rows($record) > 0) {
            $row = mysqli_fetch_array($record);

            if ($row['status'] == 'Blocked') {
                $swal = 'error';
                $fb = 'Access denied.';

            } elseif ($row['status'] == 'Pending') {
                $swallnfo = 'error';
                $fb = 'Account not yet activated.';

            } elseif ($row['status'] =='Approved') {

                $_SESSION['nID']= $row['cust_id'];
                $_SESSION['nuser']= $row['username'];

                header('location:profile.php');

            } else {
                $swal = 'error';
                $fb = ' Invalid login details';
            }

        }
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
          //  include 'php_files/sidebar.php';

            if($swal=='error'){
                echo'<script>
swal("","'.$fb.'","error")
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
                    <li class="active">Login</li>
                </ul>

                <hr class="soft"/>

                <div class="span4 offset1">
                    <div class="well text-center">
                        <h5> LOGIN HERE</h5>
                        <form method="post"autocomplete="off">
                                <label class="control-label" for="inputEmail1">Login as</label>
                            <select id="inputEmail1"name="loginAs" required>
                                <option><?php echo $loginAs?></option>
                                <option>Customer</option>
                                <option>Supplier</option>

                            </select>
                                <label class="control-label" for="inputEmail1">Username</label>

                                <input class="span3"  type="text" name="username"value="<?php echo $username?>" id="inputEmail1" placeholder="Username">

                                <label class="control-label" for="inputPassword1">Password</label>

                                    <input type="password"  name="password"value="<?php echo $password?>"class="span3"  id="inputPassword1" placeholder="Password">

                                <div class="controls">
                                    <button type="submit" class="btn btn-danger"name="loginBtn">Login</button>

                                </div>
                            <?php
                            echo $fb;
                            ?>
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