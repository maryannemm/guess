<?php
error_reporting(E_ERROR);
session_start();
if(empty($_SESSION['token'])){
    header('location:../');
}
include "../../php_files/config.php";


if(isset($_POST['downloadBtn'])){

    $upload_dir='../../journals/';// file directory
      $filename=$_POST['filename'];


    $filePath="../../journals/".$filename;
    $filename=$filename;
    header('Content-type:application/pdf');
    header('Content-disposition: inline; filename="'.$filename.'"');
    header('content-Transfer-Encoding:binary');
    header('Accept-Ranges:bytes');
    @ readfile($filePath);


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
swal("ERROR","'.$fb.'","error")
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
                include '../../php_files/admin_left_bar.php';
                ?>
            </div>
            <!--------Left navbar ----------------->
            <article class="col-sm-9 col-lg-10 main-content" id="main-content" style="min-height: 1164px; height: 1154px;">



            <div id="iframe" class="">
                <section class="container-fluid">


                <h2 class="legend">Uploads</h2>
                        <fieldset class="">


                            <div class="table-responsive form-group col-md-12">
                                <?php
                                $select="SELECT * FROM journals  WHERE j_code='".$_GET['get']."'";
                                $query=mysqli_query($con,$select);
                                $row=mysqli_fetch_array($query);

                                echo '<p style="font-weight: bolder">'.$row['journal'].'</p>';
                                ?>

                               <table  id="dataTables-example" class="table table-striped table-responsive">
                                   <thead >
                                   <th>#</th>
                                   <th>Title</th>
                                   <th>Upload Date</th>
                                   <th>Download</th>
                                   </thead>


                                   <?php
                                   $select="SELECT * FROM journals j INNER JOIN uploads u ON j.journal_id=u.journal_id
                                     WHERE j.j_code='".$_GET['get']."'";
                                   $query=mysqli_query($con,$select);
                                   while ($row=mysqli_fetch_array($query)) {

                                       ?>
                                       <tr>
                                           <td><?php echo $row['id'] ?></td>
                                           <td><?php echo $row['title'] ?></td>
                                           <td><?php echo $row['upload_date'] ?></td>
                                           <td>

                                               <form method="post">
                                                   <input type="hidden"name="filename" value="<?php echo  $row['file_name'] ?>">

                                                   <button class="btn btn-sm btn-link" name="downloadBtn">
                                                       <img src="../../img/download-16.png"></button>
                                                   <a href="edit_uploads.php?get=<?php echo $row['j_code']?>">
                                                       <button type="button" class="btn btn-sm btn-link" name="downloadBtn">
                                                           <img src="../../img/icons8-edit-24.png"></button></a>
                                                   <a href="delete_uploads.php?get=<?php echo $row['j_code']?>">
                                                       <button type="button" class="btn btn-sm btn-link" name="downloadBtn">
                                                           <img src="../../img/icons8-remove-24.png"></button></a>

                                               </form>
                                           </td>
                                       </tr>
                                       <?php


                                   }
                                   if($no=mysqli_num_rows($query)<1){
                                      ?>
                                       <tr>
                                           <td colspan="4" style="text-align: center;color: darkred;font-weight: bolder"><h3>No upload yet</h3></td>
                                       </tr>
                                   <?php
                                   }

                                   ?>


                               </table>
                                <script>
                                    function myFunction() {
                                        var input, filter, table, tr, td, i, txtValue;
                                        input = document.getElementById("myInput");
                                        filter = input.value.toUpperCase();
                                        table = document.getElementById("myTable");
                                        tr = table.getElementsByTagName("tr");
                                        for (i = 0; i < tr.length; i++) {
                                            td = tr[i].getElementsByTagName("td")[0];
                                            if (td) {
                                                txtValue = td.textContent || td.innerText;
                                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                                    tr[i].style.display = "";
                                                } else {
                                                    tr[i].style.display = "none";
                                                }
                                            }
                                        }
                                    }
                                </script>


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
               </body></html>