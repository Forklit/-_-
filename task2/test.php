<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$httpClient = new Client();

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'test1';

// Создать подключение к базе данных
$conn = new mysqli($servername, $username, $password, $database);

// Проверьте соединение
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$response = $httpClient->get('https://www.bills.ru/');

$htmlString = (string) $response->getBody();

// Добавил эту строку, чтобы подавить любые предупреждения
libxml_use_internal_errors(true);

//Парсил необходимую дату
$doc = new DOMDocument();
$doc->loadHTML($htmlString);

$xpath = new DOMXPath($doc);

$date = date('Y-m-d H:i:s');
$titleNodes = $xpath->query('//div[@class="titles"]');
$title = [];

foreach ($titleNodes as $key => $var) {
    $title[] = $var->textContent;
    // echo $title[$key];
}

$string_version = implode(',', $title);

    // SQL запрос
$query = "INSERT INTO bills_ru_events (title, date) VALUES ('$string_version','$date')";

    //Выполнить запрос
$result = $conn->query($query);
if ($result) {
        echo "Успешно добавлен";
    }

else{
        echo "Ошибка: " . $conn->error;
    }

$conn->close();