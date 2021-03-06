<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";

if(isset($_POST['updateBtn'])){
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $username=$_POST['username'];
    $phoneno=$_POST['phoneno'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role=$_POST['role'];


    if(empty($firstname)|| empty($lastname)|| empty($username)|| empty($phoneno)|| empty($email)||  empty($password)||  empty($role)){
        $swal="error";
        $fb="All fields are required";

    }elseif(!preg_match ('/^([a-zA-Z]+)$/',$firstname)){
        $swal='error';
        $fb='First name should contain only letters';
    }elseif(!preg_match ('/^([a-zA-Z]+)$/',$lastname)){
        $swal='error';
        $fb=' Last name should contain only letters';
    }elseif(!preg_match ('/^([a-zA-Z]+)$/',$username)){
        $swal='error';
        $fb='Username should contain only letters';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $swal='error';
        $fb='Wrong email format';


    }elseif(!is_numeric($phoneno)){
        $swal='error';
        $fb='Phone number should contain numbers only ';


    }elseif(strlen($phoneno)<>10){
        $swal='error';
        $fb='Phone number musr have 10  numbers';

    }elseif(strlen($password)<4) {

        $swal='error';
        $fb='Password too short should have at least 4 characters';


    }else{
        // check if user name exist
        $select="SELECT * FROM staff WHERE staff_username='$username' AND NOT staff_id='".$_GET['v']."'";
        $query=mysqli_query($con,$select);
        if($check=mysqli_num_rows($query)>0){
            $swal="error";
            $fb="Username exist";
        }else{

            // check if phone no exist
            $select="SELECT * FROM staff WHERE staff_phonenumber='$phoneno' AND NOT staff_id='".$_GET['v']."'";
            $query=mysqli_query($con,$select);
            if($check=mysqli_num_rows($query)>0){
                $swal="error";
                $fb="Phone number exist";
            }else{
                // check if email exist
                $select="SELECT * FROM staff WHERE staff_email='$email' AND NOT staff_id='".$_GET['v']."'";
                $query=mysqli_query($con,$select);
                if($check=mysqli_num_rows($query)>0){
                    $swal="error";
                    $fb="Email exist";
                }else{




                    $update="UPDATE  staff SET firstname='$firstname',lastname='$lastname',staff_username='$username',staff_phonenumber='$phoneno',
                  staff_email='$email',staff_password='$password',user_level='$role'WHERE staff_id='".$_GET['v']."'";
                    if(mysqli_query($con,$update)){
                        $_SESSION['success']='Updated successfully';
                        header('location:employees.php');

                    }else{
                        $swal='error';
                        $fb='Please try again';
                    }
                }
            }
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


                        <h2 class="legend">Update Employees</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-4">
                                <?php
                                $select="SELECT * FROM staff WHERE staff_id='".$_GET['v']."' ";
                                $query=mysqli_query($con,$select);
                                $row=mysqli_fetch_array($query);
                                ?>

                                <form id="fupForm" method="post" autocomplete="off">
                                    <label>First name</label>
                                    <input type="text"class="form-control" name="firstname"value="<?php echo $row['firstname']?>">
                                    <label>Last name</label>
                                    <input type="text" class="form-control"name="lastname"value="<?php echo$row['lastname']?>">
                                    <label>Email</label>
                                    <input type="text" class="form-control"name="email"value="<?php echo$row['staff_email']?>">
                                    <label>Username</label>
                                    <input type="text" class="form-control"name="username"value="<?php echo$row['staff_username']?>">


                            </div>
                            <div class="table-responsive form-group col-md-4">
                                <label>Contact</label>
                                <input type="text" class="form-control"name="phoneno"value="<?php echo$row['staff_phonenumber']?>">

                                <label>User level</label>
                                <select class="form-control"name="role">
                                    <option><?php echo $row['user_level']?></option>
                                    <option>Cashier</option>
                                    <option>Procurement</option>
                                </select>    <label>Password</label>
                                <input type="password" class="form-control"name="password"value="<?php echo$row['staff_password']?>">
                                <label>.</label>

                                <input type="submit" name="updateBtn"class="btn form-control btn-sm btn-primary submitBtn" value="Edit">

                                </form>

                            </div>

                            <div class="table-responsive form-group col-md-12">


                            </div>

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