<?php
/**
 * Created by PhpStorm.
 * User: jameshill
 * Date: 6/5/15
 * Time: 11:35 AM
 */

session_start();

$productId = $_GET['productId'];

unset($_SESSION['cart'][$productId]);

?>