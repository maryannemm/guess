<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";


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
                <h2 class="legend">Stock in</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-12">

                                <table id="example" class="table table-bordered">
                                    <thead>



                                    <tr>
                                        <th> Supplier</th>
                                        <th> Product</th>
                                        <th> Quantity</th>
                                        <th> Date</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $select="SELECT * FROM stock_in si INNER JOIN suppliers s ON si.supplier_id=s.supplier_id";
                                    $query=mysqli_query($con,$select);
                                    while($row=mysqli_fetch_array($query)){
                                        ?>
                                        <tr class="odd gradeX">

                                            <td><?php echo $row['supplier_name'] ?></td>
                                            <td><?php
                                                $get="SELECT product_name FROM product WHERE product_id=".$row['product_id'];
                                                $qrly=mysqli_query($con,$get);
                                                $rowP=mysqli_fetch_array($qrly);

                                                echo $rowP['product_name'] ?></td>
                                            <td><?php echo $row['quantity']?>
                                            <td><?php echo $row['date_supplied']?>

                                            </td>
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


<!--<script type="text/javascript" >-->
<!---->
<!--    function readURL(input) {-->
<!---->
<!--        if (input.files && input.files[0]) {-->
<!--            var reader = new FileReader();-->
<!---->
<!--            reader.onload = function (e) {-->
<!--                $('#image_upload_preview').attr('src', e.target.result);-->
<!--            }-->
<!---->
<!--            reader.readAsDataURL(input.files[0]);-->
<!--        }-->
<!--    }-->
<!---->
<!--    $("#inputFile").change(function () {-->
<!--        readURL(this);-->
<!--    });-->
<!--</script>-->

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
                            columns: [0,1,2,3]
                        }
                    },

                ]

            }
        );

    });


</script>

               </body>
</html>