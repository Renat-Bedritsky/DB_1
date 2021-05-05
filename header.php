<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/media.css">
    <style>
    
    </style>
</head>
<body>

<div class="window">

<div class="content">

<header class="header">

    <div>
        <img src="/img/logo_header.png" alt="logo" class="logo" width="100">
    </div>

    <div class="nav">
        <ul>
            <li><a href="/index.php">Shop</a></li>
            <li><a href="/record.php">Add</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>



<?php

if (isset($_COOKIE['basket'])) {
    $product = $_COOKIE['basket'];
    $products = explode(',', $product);
}

// echo '<pre>';
// print_r($products);
// echo '</pre>';

$quantity = 0;
if (isset($products[0])) {
    foreach ($products as $key => $value) {
        $quantity++;      // Счётчик товаров в корзине
    }
}

?>



    <div class="basket">
        <span class="quantity"><?= $quantity; ?></span>
        <a href="/index.php/?basket"><img src="/img/basket.png" alt="basket" class="basket" width="30"></a>
    </div>

</header>
    
