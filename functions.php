<?php require_once './connect.php'; ?>   <!-- Подключение к базе данных -->

<div class="title">

    <h1>Products</h1>

</div>

<?php 

$dir = $_GET['id'] ?? '.\\';   // Если 'dir' существует, то принимает 'dir', иначе \
// $dir = realpath($dir);          // Абсолютный путь к файлу
// chdir($dir);                    // Изменяет текущий каталог на указанный
// echo $dir;
// echo $_SERVER['DOCUMENT_ROOT'];
// echo $_SERVER['PHP_SELF'];





if (isset($_POST['addBasket'])) {

    if(isset($_COOKIE['basket'])){
        $products = explode(',', $_COOKIE['basket']);   // Преобразование строки в массив
        if(!in_array($_POST['addBasket'], $products)){
            $products[] = $_POST['addBasket'];
        }
        
    }
    else{
        $products[] = $_POST['addBasket'];
    }

    $str = implode(',', $products);                     // Преобразование массива в строку
    setcookie('basket', $str, time()+1800);
    header("Refresh:0");                                // Это для обновления страницы при нажатии кнопки "В корзину"
  
}





// Скрипт для удаления товаров из корзины

if (isset($_POST['delBasket'])) {
    foreach ($products as $key => $item) {
        if ($_POST['delBasket'] == $item) {
            array_splice($products, $key, 1);          // Удаляет значение массива
            $str = implode(',', $products);
            setcookie('basket', $str, time()+1800);    // Перезаписывает куки
            header("Refresh:0");                       // Обновление страницы
        }
    }
}

?>





<div class='select'>
    <form method="POST">
        <select name="category">
            <option value="all">all</option>
            <option value="men clothing">men clothing</option>
            <option value="women clothing">women clothing</option>
            <option value="jewelery">jewelery</option>
            <option value="electronics">electronics</option>
        </select>
        <button>OK</button>
    </form>
</div>





<?php

// Функция для вывода списка товаров

function showProducts() {
    
    if (isset($_POST['category']) && $_POST['category'] != 'all') {
        $category = $_POST['category'];
    }
    else if (!isset($_POST['category']) || $_POST['category'] == 'all') {
        $category = 1;                          // Текст запроса
    }
    
    $shop = new Shop();                  // Создание нового объекта
    $data = $shop->getProducts($category);    // Отправка запроса
    $data = (array)$data;                // Преобразование объекта в массив

    $html = "";

    foreach($data as $product) {
        $html .= '
        <div class="product">
            <a href="/index.php/?id='.($product['id']).'"><img src="'.$product['images'].'" alt="'.$product['title'].'"></a>
            <h3>'. $product['title'] .'</h3>
            <div class="product_price">$'.$product['price'].'</div>
        </div>';

        // Передаёт в функцию информацию о товаре, выбранный пользователем
        addProduct($product['id'],
                   $product['title'], 
                   $product['images'], 
                   $product['price'], 
                   $product['descript']
                );
    }
    if (!empty($html)) echo '<div class="products_list">'.$html.'</div>';
}

showProducts();





// Функция для вывода товара, выбранного пользователем

function addProduct($id, $title, $images, $price, $descript) {
    if (isset($_GET['id'])) {
        if ($_GET['id'] == $id) {
        ?>

            <style>.select{display:none;}.product{display:none;}</style>
            <div class="thing">
                <img src="<?= $images; ?>" alt="foto">
                <div class="object">
                    <p><b><?= $title; ?></b></p>
                    <p><?= $descript; ?></p>
                    <p>Price: $<?= $price; ?></p>

                    <!-- Форма для добавления товара в корзину -->
                    <form method="POST">
                        <input type="hidden" name="addBasket" value="<?= $id?>">
                        <button class="add_basket_button">В корзину</button>
                    </form>

                </div>
            </div>

            <?php 
            
        }
    }
}





// Корзина

if (isset($_GET['basket'])) { ?>

    <style>.select{display:none;}.product{display:none;}.title{display:none}</style>
    <div class="title_basket">
        <h1>Basket</h1>
    </div>

    <?php

    $shop = new Shop();                 // Создание нового объекта
    $data = $shop->getProducts(1);      // Отправка запроса
    $data = (array)$data;               // Преобразование объекта в массив
    $cost = 0;                          // Общая стоимость товара

    foreach ($data as $product) {
        if (isset($_COOKIE['basket'])) {
            foreach ($products as $id) {
                if ($product['id'] == $id) {
                    $cost += $product['price']; ?>

                    <div class="thing">
                        <p class="thing_img"><img src="<?= $product['images']; ?>" alt="foto"></p>
                        <div class="object">
                            <p><b><?= $product['title']; ?></b></p>
                            <p><?= $product['descript']; ?></p>
                            <p>Price: $<?= $product['price']; ?></p>

                            <!-- Форма для удаления товара из корзины -->
                            <form method="POST">
                                <input type="hidden" name="delBasket" value="<?= $product['id'] ?>">
                                <button class="add_basket_button">Удалить</button>
                            </form>

                        </div>
                    </div>

                    <?php
                }
            }
        }
        else { ?>

            <div class="basket_zero">
                <h2>Корзина пуста</h2>
            </div>

            <?php
            break;
        }
    }

    if (isset($_COOKIE['basket'])) { ?>

        <div class="cost_basket">Итоговая стоимость: $<?= $cost ?></div>

    <?php
    }
}