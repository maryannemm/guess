<?php
$sel="SELECT * FROM order_items WHERE cust_id='".$_SESSION['nID']."'AND item_status='Cart'";
$get=mysqli_query($con,$sel);
$cart=mysqli_num_rows($get);

?>

<div id="header">
    <div class="container">
        <div id="welcomeLine" class="row">
            <div class="span6">Welcome!<strong> <?php echo $_SESSION['nuser']?></strong></div>
            <div class="span6">
                <div class="pull-right">
                    <?php
                    if($cart>0){
                        ?>
                        <a href="cart.php"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <?php echo $cart?> ] Itemes in your cart </span> </a>

                        <?php
                    }else{
                        ?>
                        <a href="#c" onclick="swal('','Your cart is empty','')"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i>[0]Itemes in your cart </span> </a>

                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <!-- Navbar ================================================== -->
        <div id="logoArea" class="navbar">
            <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-inner">
                <a class="brand" href="index.php"><h3 style="color: #fff;"><?php echo $siteName?></h3></a>
                <form class="form-inline navbar-search" method="get" action="search.php"autocomplete="off" >
                    <input id=""list="srch" name="searchText" type="text" />
                    <datalist id="srch">
                        <?php
                        $select="SELECT product_name FROM product";
                        $query=mysqli_query($con,$select);
                        while($row=mysqli_fetch_array($query)){
                            ?>
                        <option value="<?php echo $row['product_name'] ?>">
                        <?php
                        }
                        ?>
                    </datalist>
                    <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
                </form>
                <ul id="topMenu" class="nav pull-right">
                    <li class=""><a href="index.php">Home</a></li>
                    <li class=""><a href="help.php">Help/FAQs</a></li>

                    <?php
                    if(!empty($_SESSION['nID'])){
                    ?>
                    <li class=""><a href="profile.php"><?php echo $_SESSION['nuser'] ?></a></li>
                    <li class=""><a href="logout.php">Logout</a></li>
                    <?php

                        }elseif (!empty($_SESSION['suser'])){
                        ?>
                        <li class=""><a href="profile_supplier.php"><?php echo $_SESSION['suser'] ?></a></li>
                        <li class=""><a href="logout.php">Logout</a></li>
                        <?php

                    }else{
                        ?>
                        <li class=""><a href="register_as.php">Register</a></li>
                        <li class=""><a href="login.php">Login</a></li>
                        <li class=""><a href="admin/">Staff</a></li>
                    <?php
                    }
                    ?>


                </ul>
            </div>
        </div>
    </div>
</div>