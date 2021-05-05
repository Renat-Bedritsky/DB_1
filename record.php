<?php 
require_once './header.php';
require_once './connect.php';   // Подключение к базе данных
?>



<div class="title">

    <h1>Add</h1>

</div>

<?php

if (isset($_POST['title'])) {

    $shop = new Shop();
    $idSql = $shop->getProducts('SELECT COUNT(*) FROM products');

    $id = $idSql[0]['COUNT(*)'] + 1;
    $title = $_POST['title'];
    $price = $_POST['price'];
    $descript = $_POST['descript'];
    $category = $_POST['category'];
    $images = $_POST['images'];

    $sql = "INSERT INTO products (id, title, price, descript, category, images) VALUES ($id, '$title', $price, '$descript', '$category', '$images')";
    $data = $shop->setProducts($sql);

    if ($data == 1) echo 'Добавлено успешно';
    else if ($data == 0) echo 'Не добавлено';
    else echo 'Ничего';

    header("location: /index.php");
}

?>



<form method="POST" name="add_product">
    Название товара:        <br><input type="text" name="title" value="" required><br>
    Цена товара:            <br><input type="text" name="price" value="" required><br>
    Описание товара:        <br><input type="text" name="descript" value="" required><br>
    Категория товара:       <br>
                                <select name="category">
                                    <option value="men's clothing">men's clothing</option>
                                    <option value="women's clothing">women's clothing</option>
                                    <option value="jewelery">jewelery</option>
                                    <option value="electronics">electronics</option>
                                </select><br>
    Ссылка на фотографию:   <br><input type="text" name="images" value="" required><br>
    <button>Добавить</button>
</form>




<?php require_once './footer.php';