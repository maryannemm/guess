<?php
error_reporting(E_ERROR);
session_start();

include "../php_files/config.php";


if(isset($_POST['loginBtn'])){
    $username=$_POST['username'];
    $password=$_POST['password'];


    if(empty($username)||empty($password)){
        $swal='error';
         $fb='Username or password is missing';

    }else{
        $select="SELECT * FROM staff WHERE staff_username='$username' AND staff_password='$password'";
        $record=mysqli_query($con,$select);
        if($check=mysqli_num_rows($record)>0){

            $row=mysqli_fetch_array($record);
            $_SESSION['user']=$row['user_level'];

            if($row['status']=='Blocked'){
                $swal='error';
                $fb='You have no access to your account.';

            }elseif($_SESSION['user']=='Admin'){
                $_SESSION['userID']=$row['staff_id'];

                $_SESSION['user']=$row['user_level'];
                header('location:home.php');
                echo  'success.';
            }elseif($_SESSION['user']=='Procurement'){

                $_SESSION['userID']=$row['staff_id'];
                $_SESSION['user']=$row['user_level'];

                header('location:home.php');
            }elseif ($_SESSION['user']=='Cashier'){

                $_SESSION['userID']=$row['staff_id'];
                $_SESSION['user']=$row['user_level'];
                   header('location:home.php');
            }
        }else{
            $swal='error';
             	$fb=' Invalid login credentials';
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
    <link href="css_file/bootstrap.min.css">
    <![endif]-->

    <script src="js/b28n.js"></script>
    <script src="js/custom-sweetalert.js"></script>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>
<body class="index-body">
<?php
if($swal=='error'){
    echo '<script>
    swal("Failed","'.$fb.'","error");
</script>';
}
if($swal=='success'){
    echo '<script>
    swal("","'.$fb.'","success");
</script>';
}
?>

<noscript>
    <div id="testJs" class="test-tips">

    </div>
</noscript>
<div id="main_content" class="none" style="display: block;">

    <section class="container"style="height: auto;margin-top: 100px">
        <div class="row main-container">
<div class="col-lg-4"></div>
            <article class="col-sm-9 col-lg-4 main-content" id="main-content" >
                <h2 class="legend"><?php echo $siteName?></h2>
                <hr>
                <form method="post" autocomplete="off">
                <label>Username</label>
                <input type="text"class="form-control"name="username"value="<?php echo $username?>">
                  <label>Password</label>
                    <input type="password"class="form-control"name="password" value="<?php echo $password?>">
                <br>
                <input type="submit"class="btn btn-danger"name="loginBtn" value="Login">
                </form>
                <br>
                <hr>



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
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#fupForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../php_code/insert_journal.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");// disable the button
                    $('.submitBtn').css("display","none");// hide the button
                    $('.gif-load').css("display","");// Show loading gif
                    $('#fupForm').css("opacity",".8");
                    swal("",'Submitting.......\nPlease wait');
                },
                success: function(response){ //console.log(response);
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#fupForm')[0].reset();
                        swal("Success",''+response.message+'',"success");
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }else{
                        swal("Error",''+response.message+'',"error");
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    $('#fupForm').css("opacity","");
                    $(".submitBtn").removeAttr("disabled"); // enable the button
                    $('.submitBtn').css("display",""); //display the button
                    $('.gif-load').css("display","none"); //hide loading gif
                }
            });
        });
    });
</script>
<script>


    $(document).ready(function () {

        var datatable = $('#dataTables-example').dataTable(


        );

    });
</script>
               </body></html>