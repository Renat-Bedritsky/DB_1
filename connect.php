<?php

class Shop {
    public $servername = 'localhost';
    public $username = 'root';
    public $password = '';
    public $dbname = 'shop';

    
    // Общая функция для подключения к базе данных
    function general($sql) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);   // Установка соединения
        $string = $conn->query($sql);                                                             // Отправка запроса
        return $string;
    
        $conn->close();
    }


    // Функция для получения данных
    function getProducts($sql) {
        $string = $this->general($sql);
        $result = [];                                                                             // Пустой массив для товаров

        if($string) {
            while ($row = $string->fetch_assoc()) {                                               // fetch_assoc() извлекает запись
                array_push($result, $row);                                                        // Добавление записи в массив
            }
            return $result;
        }
    }


    // Функция для записи данных
    function setProducts($sql) {
        $string = $this->general($sql);
        if($string) return 1;
        else return 0;
    }
}

?>