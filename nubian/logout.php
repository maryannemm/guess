<?php
/**
 * Created by PhpStorm.
 * User: Mwafrika
 * Date: 1/4/2020
 * Time: 9:16 PM
 */

session_start();
session_destroy();
header('location:index.php');
?>