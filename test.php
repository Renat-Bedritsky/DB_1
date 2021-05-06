<?php require_once './connect.php';

$shop = new Shop;
$result = $shop->getProducts(0);
print_r($result);
echo $result[0]['COUNT(*)'];