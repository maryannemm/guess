<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";

if(isset($_POST['submitBtn'])){

    $name=$_POST['name'];
    $cost=$_POST['cost'];
if(empty($name)||empty($cost)){
    $swal='error';
    $fb='No empty fields allowed';
    }elseif(!is_numeric($cost)){
        $swal='error';
        $fb='Please enter a numeric value';
    }else{
    $select="SELECT * FROM shipping_company WHERE comp_name='$name'";
    $query=mysqli_query($con,$select);
    if($row=mysqli_num_rows($query)>0){
        $swal='error';
        $fb='Shipping company already in the system';
    }else{


        $insert="INSERT INTO shipping_company(comp_name, shipping_cost)
            VALUES('$name','$cost')";
        if(mysqli_query($con,$insert)){
            $name='';
            $cost='';
            $swal='success';
            $fb='Added successfully';
        }else{
            $swal='error';
            $fb='Failed to stock added';
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
    <link rel="shortcut icon" href="http://192.168.0.1/favicon.ico">
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
</head>
<body class="index-body">
<noscript>
    <div id="testJs" class="test-tips">
        <p>Error! The browser does not support JavaScript. </p>
        <p>Please enable JavaScript or try another browser compatible with JavaScript to
			experience more features.
		</p>
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


                <h2 class="legend">Shipping companies</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-4">

                                <form id="fupForm" method="post"enctype="multipart/form-data" autocomplete="off">
                                    <label>Company name</label>
                                    <input type="text"class="form-control" name="name"value="<?php echo $name?>" required>
                                    <label>Shipping cost</label>
                                    <input type="number" class="form-control"name="cost"value="<?php echo$cost?>"required>

                                    <br>

                                    <input type="submit" name="submitBtn"class="btn form-control btn-sm btn-primary submitBtn">
                                </form>
                            </div>


                            <div class="table-responsive form-group col-md-12">

                                <table id="example"class="table table-striped table-responsive tableData">
                                    <thead>
                                    <tr>
                                        <th> Action</th>
                                        <th> ID</th>
                                        <th> Company name</th>
                                        <th> Shipping cost</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $select="SELECT * FROM shipping_company";
                                    $query=mysqli_query($con,$select);
                                    while($row=mysqli_fetch_array($query)){
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>

                                                <a href="edit_comp.php?v=<?php echo $row['company_id']?>" class="text-success"style="font-weight: bolder">
                                                    Edit</a>

                                            </td>
                                            <td><?php echo $row['company_id'] ?></td>
                                            <td><?php echo $row['comp_name'] ?></td>
                                            <td><?php echo number_format($row['shipping_cost']) ?> Ksh </td>


                                        </tr>
                                        <?php

                                    }
                                    ?>
                                    </tbody>
                                </table>



                        </fieldset>
                    <hr>
                    <hr>
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
                            columns: [1,2,3]
                        }
                    },

                ]

            }
        );

    });


</script>
               </body>
</html>