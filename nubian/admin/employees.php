<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";

if(isset($_POST['submitBtn'])){
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
        $select="SELECT * FROM staff WHERE staff_username='$username'";
        $query=mysqli_query($con,$select);
        if($check=mysqli_num_rows($query)>0){
            $swal="error";
            $fb="Username exist";
        }else{

            // check if phone no exist
            $select="SELECT * FROM staff WHERE staff_phonenumber='$phoneno'";
            $query=mysqli_query($con,$select);
            if($check=mysqli_num_rows($query)>0){
                $swal="error";
                $fb="Phone number exist";
            }else{
                // check if email exist
                $select="SELECT * FROM staff WHERE staff_email='$email'";
                $query=mysqli_query($con,$select);
                if($check=mysqli_num_rows($query)>0){
                    $swal="error";
                    $fb="Email exist";
                }else{




                    $insert="INSERT INTO staff(firstname,lastname,staff_username,staff_phonenumber,staff_email,staff_password,user_level) VALUES 
	('$firstname','$lastname','$username','$phoneno','$email','$password','$role')";
                    if(mysqli_query($con,$insert)){
                        $swal='success';
                        $fb='submitted successfully';
                        $firstname="";
                        $lastname="";
                        $username="";
                        $phoneno="";
                        $email="";
                        $password="";
                        $role="";
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
    include '../php_files/admin_topbar.php';


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
   if(!empty($_SESSION['success'])){
        echo'<script>
swal("","'.$_SESSION['success'].'","success")
</script>';
       $_SESSION['success']='';
    }

    ?>
    <!---------- /header --------------->

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


                <h2 class="legend">Employees</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-4">

                                        <form id="fupForm" method="post" autocomplete="off">
                                            <label>First name</label>
                                            <input type="text"class="form-control" name="firstname"value="<?php echo $firstname?>">
                                           <label>Last name</label>
                                            <input type="text" class="form-control"name="lastname"value="<?php echo$lastname?>">
                                           <label>Email</label>
                                            <input type="text" class="form-control"name="email"value="<?php echo$email?>">
                                            <label>Username</label>
                                            <input type="text" class="form-control"name="username"value="<?php echo$username?>">


                            </div>
                            <div class="table-responsive form-group col-md-4">
                                <label>Contact</label>
                                <input type="text" class="form-control"name="phoneno"value="<?php echo$phoneno?>">

                                <label>User level</label>
                                <select class="form-control"name="role">
                                    <option><?php echo $role?></option>
                                    <option>Cashier</option>
                                    <option>Procurement</option>
                                </select>    <label>Password</label>
                                            <input type="password" class="form-control"name="password"value="<?php echo$password?>">
                                <label>.</label>

                                            <input type="submit" name="submitBtn"class="btn form-control btn-sm btn-primary submitBtn">

                                        </form>

                            </div>

                            <div class="table-responsive form-group col-md-12">

                                <table id="example"class="table table-striped table-responsive tableData">

                                   <thead>
                                   <th>#</th>
                                   <th>Name</th>
                                   <th>Username</th>
                                   <th>Email</th>
                                   <th>Contact</th>
                                   <th>User level</th>
                                   <th>Status</th>
                                   <th>Date added</th>
                                   <th>Manage</th>
                                   </thead>



                                   <?php
                                   $select="SELECT * FROM staff WHERE NOT user_level='Admin' ";
                                   $query=mysqli_query($con,$select);
                                   while ($row=mysqli_fetch_array($query)) {

                                       ?>
                                       <tr class="header">
                                           <td><?php echo $row['staff_id'] ?></td>
                                           <td><?php echo $row['firstname'].' '. $row['lastname'] ?></td>
                                           <td><?php echo $row['staff_username'] ?></td>
                                           <td><?php echo $row['staff_email'] ?></td>
                                           <td><?php echo $row['staff_phonenumber'] ?></td>
                                           <td><?php echo $row['user_level'] ?></td>
                                           <td><?php echo $row['staff_status'] ?></td>
                                           <td><?php echo $row['date_added'] ?></td>
                                           <td><a href="edit_staff.php?v=<?php echo $row['staff_id']?>">Edit</a> </td>
                                       </tr>
                                       <?php
                                   }
                                   ?>


                               </table>

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


<link href="../datatable/css/jquery.dataTables.css" rel="stylesheet" />
<link href="../datatable/css/buttons.dataTables.css" rel="stylesheet" />

<script src="../datatable/js/jquery.dataTables.min.js"></script>
<script src="../datatable/js/jszip.min.js"></script>
<script src="../datatable/js/dataTables.buttons.min.js"></script>
<script src="../datatable/js/pdfmake.min.js"></script>
<script src="../datatable/js/vfs_fonts.js"></script>
<script src="../datatable/js/buttons.html5.min.js"></script>


<script>

    $(document).ready(function () {

        var datatable = $('#example').dataTable(

            {
                "dom": 'lBfrtip',
                "buttons": [
                    {
                        extend: 'pdf',

                        footer: true,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7]
                        }
                    },

                ]

            }
        );

    });


</script>
               </body></html>