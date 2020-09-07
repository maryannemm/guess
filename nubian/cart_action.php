<?php
/**
 * Created by PhpStorm.
 * User: Mwafrika
 * Date: 10/12/2019
 * Time: 2:12 PM
 */
session_start();
if (isset($_POST['cartBtn'])){

    require_once 'php_files/config.php';


    $productID=$_POST['hID'];
    $qty=$_POST['qty'];



    // check item quantity

    $select="SELECT stock,product_price FROM product WHERE product_id='$productID'";
    $record=mysqli_query($con,$select);
    $row=mysqli_fetch_array($record);
    $price=$row['product_price'];
    if($qty >$row['stock'] ){

        $swal = 'error';
        $fb = 'You cannot buy more than stock available ';



    }else{



        $select= "SELECT * FROM order_items WHERE product_id='$productID' AND  item_status='Cart'AND  cust_id='".$_SESSION['nID']."' ";
        $records=mysqli_query($con,$select);
        if($get=mysqli_num_rows($records) >0){
            $swal = 'error';
            $fb ='Product already in your cart';

        }else{
            // check if student has an active order
            $select="SELECT * FROM orders WHERE  order_status='Cart'AND cust_id='".$_SESSION['nID']."' ";
            $record=mysqli_query($con,$select);
            if ($row=mysqli_num_rows($record) < 1 ){
                // if no active order insert in to order tables new order
                $insert="INSERT INTO orders(cust_id)VALUES ('".$_SESSION['nID']."')";

                mysqli_query($con,$insert);
                // get the order number of the last inserted id
                $orderNo=mysqli_insert_id($con);

                // insert the order items
                $insrt= "INSERT INTO order_items (cust_id, order_id, product_id, item_quantity, price)
             VALUES ('" .$_SESSION['nID']."','$orderNo', '$productID', '$qty', '$price')";
                if (mysqli_query($con,$insrt)) {

                    $swal = 'success';
                    $fb ='Added to cart';

                }else{

                    $swal = 'error';
                    $fb ='Failed to add to cart';


                }

            }else{
                // get the order number of an active order
                $select="SELECT * FROM orders WHERE order_status='Cart' AND cust_id='".$_SESSION['nID']."' ";
                $record=mysqli_query($con,$select);
                $rowC=mysqli_fetch_assoc($record);
                $orderNo=$rowC['order_id'];

                // insert order items after getting the order no
                $insrt= "INSERT INTO `order_items` ( cust_id,order_id, product_id, item_quantity,price)
                  VALUES ( '" .$_SESSION['nID']."','$orderNo', '$productID', '$qty', '$price')";
                if (mysqli_query($con,$insrt)) {

                    $swal = 'success';
                    $fb ='Added to cart';

                }else{

                    $swal = 'error';
                    $fb ='Failed please try again';

                }
            }
        }
    }
}


// update cart items

if (isset($_POST['updateBtn'])){

    $qty=$_POST['qty'];
    $productID=$_POST['hID'];
    $itemID=$_POST['itemID'];

    // check item quantity

    $select="SELECT stock FROM product WHERE product_id='$productID'";
    $record=mysqli_query($con,$select);
    $row=mysqli_fetch_array($record);

    if($row['stock']< $qty){

        $swal = 'error';
        $fb = 'You can not buy more than stock available ';

    }else{


        $update="UPDATE order_items SET item_quantity='$qty' WHERE item_id='$itemID'";
        if(mysqli_query($con,$update)){

            $swal = 'success';
            $fb= 'Cart updated';


        }else{
            $swal = 'error';
            $fb ='Failed to update cart';

        }
    }

}

// remove cart items

if (isset($_POST['removeBtn'])){

    $itemID=$_POST['itemID'];




        $remove="DELETE  FROM order_items  WHERE item_id='$itemID'";
        if(mysqli_query($con,$remove)){

            $swal = 'success';
            $fb= 'Item removed Successfully';


        }else{
            $swal = 'error';
            $fb ='Failed to remove';

        }


}
?>

