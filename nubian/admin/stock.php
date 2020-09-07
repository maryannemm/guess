<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";

if(isset($_POST['addBtn'])){

    $addStock=$_POST['stock'];
    $hID=$_POST['hID'];
    $supplier=$_POST['supplier'];


    if(!is_numeric($addStock)){
        $swal='error';
        $fb='Please enter a numeric value';
    }else{

        $update="UPDATE product SET stock=stock+'$addStock' WHERE product_id='$hID'";
        if(mysqli_query($con,$update)){

            $select="SELECT * FROM suppliers WHERE supplier_name='$supplier'";
            $query=mysqli_query($con,$select);
            $row=mysqli_fetch_array($query);

            $supID=$row['supplier_id'];

            $insert="INSERT INTO stock_in (product_id, quantity, supplier_id)VALUES ('$hID','$addStock','$supID')";
            mysqli_query($con,$insert);

            $addStock='';
            $swal='success';
            $fb='Updated successfully';
        }else{
            $swal='error';
            $fb='Failed to stock added';
        }
    }
}


if(isset($_POST['submitBtn'])){

    $upload_dir='../uploads/';// image directory



    $imgName = $_FILES['itemImage']['name'];
    $name=$_POST['name'];
    $price=$_POST['price'];
    if(empty($name)||empty($imgName)||empty($price)){
        $swal='error';
        $fb="No empty fields allowed";
    }elseif(!is_numeric($price)){
        $swal='error';

        $fb='Price should have  numbers';


    }else{
        //image update

        $imgName = $_FILES['itemImage']['name'];
        $imgTmp = $_FILES['itemImage']['tmp_name'];
        $imgSize = $_FILES['itemImage']['size'];

        if($imgName){
            //get image extension
            $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
            //allow extenstion
            $allowExt  = array('jpeg', 'jpg', 'png', 'gif');
            //random new name for photo
            $image = time().'_'.rand(1000,9999).'.'.$imgExt;
            //check a valid image
            if(in_array($imgExt, $allowExt)){

            }else{

                $swal='error';
                $fb="please select a valid Image file";


            }
        }

        if(!$set=='error'){

            // Resize uploaded images size

            function resizeImage($resourceType,$image_width,$image_height) {
                $resizeWidth = 300;
                $resizeHeight = 300;
                $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
                imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
                return $imageLayer;
            }


            if(is_array($_FILES)) {


                $sourceProperties = getimagesize($imgTmp);
                $image = time().'_'.rand(1000,9999).'.'.$imgExt; // change image name


                


                $insert="INSERT INTO product(product_name, product_price, image) 
                 VALUES ( '$name', '$price', '$image')" ;

                if(mysqli_query($con,$insert)){
                    //  move_uploaded_file($imgTmp ,$upload_dir.$image);


                    $uploadImageType = $sourceProperties[2];
                    $sourceImageWidth = $sourceProperties[0];
                    $sourceImageHeight = $sourceProperties[1];


                    switch ($uploadImageType) {

                        case IMAGETYPE_JPEG:
                            $resourceType = imagecreatefromjpeg($imgTmp);
                            $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                            imagejpeg($imageLayer,$upload_dir.$image);
                            break;

                        case IMAGETYPE_GIF:
                            $resourceType = imagecreatefromgif($imgTmp);
                            $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                            imagegif($imageLayer,$upload_dir.$image);
                            break;

                        case IMAGETYPE_PNG:
                            $resourceType = imagecreatefrompng($imgTmp);
                            $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
                            imagepng($imageLayer,$upload_dir.$image);
                            break;

                        default:

                            break;
                    }
                }

                $swal='success';
                $fb=" Submitted successfully";

                $name='';
                $price='';


            }else{


                $set='error';
                $fb='Failed. please try again';
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


                <h2 class="legend">Stock</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-4">

                                <?php
                                if($_SESSION['user']=='Procurement'){
                                    ?>


                                <form id="fupForm" method="post"enctype="multipart/form-data" autocomplete="off">
                                    <label>Supplier </label>

                                    <label>Product name</label>
                                    <input type="text"class="form-control" name="name"value="<?php echo $name?>" required>
                                    <label>Price</label>
                                    <input type="number" class="form-control"name="price"value="<?php echo$price?>"required>


                            </div>
                            <div class="table-responsive form-group col-md-4">
                                <label>Product image</label>
                                <input type="file"id="inputFile" class="form-control"name="itemImage"value="<?php echo $image ?>" required>

                                <div id='preview'>
                                    <img id="image_upload_preview" src="http://placehold.it/100x100" alt="your image" style="max-height: 100px;max-width: 100px" />
                                </div>
                                <label>.</label>

                                <input type="submit" name="submitBtn"class="btn form-control btn-sm btn-primary submitBtn">

                                </form>


                            <?php
                            }
                            ?>
            </div>
                            <div class="table-responsive form-group col-md-12">

                                <table id="example" class="table table-bordered">
                                    <thead>



                                    <tr>
                                        <?php
                                        if($_SESSION['user']=='Procurement') {
                                            ?>
                                            <th> Action</th>
                                            <?php
                                        }
                                        ?>
                                        <th> Product</th>
                                        <th> Price</th>
                                        <th> Stock</th>
                                        <th> Image</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $select="SELECT * FROM product";
                                    $query=mysqli_query($con,$select);
                                    while($row=mysqli_fetch_array($query)){
                                        ?>
                                        <tr class="odd gradeX">
                                            <?php
                                            if($_SESSION['user']=='Procurement') {
                                                ?>
                                                <td>

                                                    <a href="edit_stock.php?v=<?php echo $row['product_id'] ?>"
                                                       class="text-success" style="font-weight: bolder">
                                                        Edit</a>
                                                    <form method="post" autocomplete="off"
                                                          style="color: black;font-weight: bolder">
                                                        <input type="hidden" name="hID"
                                                               value="<?php echo $row['product_id'] ?>">
                                                        <select name="supplier" required>
                                                            <option></option>
                                                            <?php
                                                            $select = "SELECT * FROM suppliers INNER JOIN item_sold i on suppliers.supplier_id = i.supplier_id
                                                                 WHERE i.product_id=" . $row['product_id'];
                                                            $query1 = mysqli_query($con, $select);
                                                            while ($rowS = mysqli_fetch_array($query1)) {
                                                                ?>
                                                                <option><?php echo $rowS['supplier_name'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="number" class="" name="stock" min="1"
                                                               value="<?php echo $stock ?>" placeholder="0"
                                                               style="color: black;font-weight: bolder;border-color: #080808;width: 80px "
                                                               required>
                                                        <br>
                                                        <a href="add_stock.php?get=<?php echo $row['product_id'] ?>">
                                                            <input type="submit" class="btn btn-info" value="Add stock"
                                                                   name="addBtn">
                                                        </a>
                                                    </form>
                                                </td>
                                                <?php
                                            }
                                            ?>

                                            <td><?php echo $row['product_name'] ?></td>
                                            <td><?php echo number_format($row['product_price']) ?> Ksh </td>
                                            <td><?php echo $row['stock']?>

                                            </td>
                                            <td>
                                                <?php
                                                if($_SESSION['user']=='Procurement') {
                                                    ?>
                                                    <a href="edit_image.php?v=<?php echo $row['product_id'] ?>"
                                                       class="text-warning" style="font-weight: bolder">
                                                        Edit image
                                                    </a><br>
                                                    <?php
                                                }
                                                ?>
                                                <img src="../uploads/<?php echo $row['image']?>"class="img-thumbnail" style="width: 80px;height: 80px">
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

<?php
if($_SESSION['user']=='Admin'){
    ?>
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

<?php
}else{
    ?>
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
                                columns: [1,2,3,4]
                            }
                        },

                    ]

                }
            );

        });


    </script>

    <?php
}
?>

               </body>
</html>