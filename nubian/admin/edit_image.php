<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['userID'])){
    header('location:index.php');
}
include "../php_files/config.php";


if(isset($_POST['editBtn'])){

    $upload_dir='../uploads/';// image directory



    $currentImage = $_POST['current'];
    $imgName = $_FILES['itemImage']['name'];

    if(empty($imgName)){
        $swal='error';
        $fb='No new image selected';

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
                $fb="Please select a jpeg, jpg, png, gif image format";


            }
        }

        if(!$swal=='error'){

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

                $update="UPDATE product set image='$image' WHERE product_id='".$_GET['v']."'" ;

                if(mysqli_query($con,$update)){
                    //  move_uploaded_file($imgTmp ,$upload_dir.$image);
                    unlink($upload_dir.$currentImage); // remove current image


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

                $_SESSION['success']='Image updated successfully';
                header('location:stock.php');



            }else{


                $swal='error';
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
swal("SUCCESS","'.$fb.'","success")
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


                <h2 class="legend">Stock</h2>
                        <fieldset class="">

                            <div class="table-responsive form-group col-md-4">

                                <?php
                                $select="SELECT * FROM product WHERE product_id='".$_GET['v']."'";
                                    $query=mysqli_query($con,$select);
                                    $row=mysqli_fetch_array($query);
                                ?>

                                <form id="fupForm" method="post"enctype="multipart/form-data" autocomplete="off">
                                    <img src="../uploads/<?php echo $row['image']?>"class="img-thumbnail" style="width: 100px;height: 100px">

                            </div>
                            <div class="table-responsive form-group col-md-4">
                                <input type="hidden"value="<?php echo $row['image']?>"name="current">
                                <label>Product image</label>
                                <input type="file"id="inputFile" class="form-control"name="itemImage"value="<?php echo $image ?>" required>

                                <div id='preview'>
                                    <img id="image_upload_preview" src="http://placehold.it/100x100" alt="your image" style="max-height: 100px;max-width: 100px" />

                                </div>
                                <label>.</label>
                                <input type="submit" name="editBtn"value="Change Image" class="btn form-control btn-sm btn-primary submitBtn">



                                </form>

                            </div>
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

<script>


    $(document).ready(function () {

        var datatable = $('#dataTables-example').dataTable(


        );

    });
</script>
<script type="text/javascript" >

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
    });
</script>

               </body>
</html>