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
    $idSql = $shop->getProducts(0);   // Получение количества строк в таблице

    $id = $idSql[0]['COUNT(*)'] + 1;   // Количество строк в таблице + 1
    $title = $_POST['title'];
    $price = $_POST['price'];
    $descript = $_POST['descript'];
    $category = $_POST['category'];
    $images = $_POST['images'];

    $sql = "INSERT INTO products (id, title, price, descript, category, images) VALUES ($id, '$title', $price, '$descript', '$category', '$images')";
    $data = $shop->setProducts($sql);

    header("location: /index.php");

}

?>





<div class="add_product">
    <form method="POST" name="add_product">
        Название товара:        <br><input type="text" name="title" value="" required><br>
        Цена товара:            <br><input type="text" name="price" value="" required><br>
        Описание товара:        <br><input type="text" name="descript" value="" required><br>
        Категория товара:       <br>
                                    <select name="category">
                                        <option value="men clothing">men clothing</option>
                                        <option value="women clothing">women clothing</option>
                                        <option value="jewelery">jewelery</option>
                                        <option value="electronics">electronics</option>
                                    </select><br>
        Ссылка на фотографию:   <br><input type="text" name="images" value="" required><br>
        <button>Добавить</button>
    </form>
</div>




<?php require_once './footer.php';