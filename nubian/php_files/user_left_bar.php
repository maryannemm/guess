<div class="navbar-header" style="background: #ed7020;">
    <img src="./Tenda Wireless Router_files/logo-inverse.png" alt="Tenda LOGO" class="visible-xs-inline" style="float:left;margin: 5px 0 0 3px">
    <button type="button" id="navbar-button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<nav class="navbar-collapse" id="nav-menu" style="min-height: 1164px; height: 1164px;">
    <ul class="nav nav-content" id="sub-menu">
 <?php

 if($_SESSION['user']=='Cashier'){
     ?>
   <li class="routerMode" >
            <a id="status" href="../admin/pending_orders.php" class="">
                Orders</a>
        </li>
     <?php
 }elseif($_SESSION['Procurement']){
     ?>
<li class="routerMode" >
            <a id="status" href="../admin/approved_orders.php" class="">
              Approved orders</a>
        </li>
<li class="routerMode" >
            <a id="status" href="../admin/shipping_orders.php" class="">
              Shipping orders</a>
        </li>

       <li class="routerMode" >
            <a id="status" href="../admin/delivered_orders.php" class="">
              Delivered orders</a>
        </li>

           

     <?php
 }
 ?>

         <li class="routerMode" >
            <a id="network" href="logout.php" class="">
               Logout</a>
        </li>

     </ul>
</nav>