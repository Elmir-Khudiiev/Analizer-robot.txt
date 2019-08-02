<?php

// Подключаем файл автозагрузки слассов
require(__DIR__.'/vendor/autoload.php');

// Пространство имен классов.
use classes\Robots;
use classes\Search;
use classes\Size;
use classes\Table;


$url = $_POST['url']; // Получаем ссылку с формы.

$robots = new Robots($url);
$domaine = $robots->corectURL();
$robots_content = $robots->robotsContent(); // Контент в "robots.txt"

$search = new Search($robots_content);
$search_host = $search->host(); // Поиск Host: в файле "robots.txt"
$search_sitemap = $search->siteMap(); // Поиск Sitemap: в файле "robots.txt"

$size = new Size;
if(!is_dir(__DIR__ . '/temp/')) {
    mkdir(__DIR__ . '/temp/',0700);
}
$robotsize = $size->robotSize($robots_content, __DIR__.'/temp/robots.txt'); // Проверка веса файла "robots.txt" в (кб).
unlink(__DIR__.'/temp/robots.txt'); // Удаление временного файла "robots.txt"
rmdir(__DIR__.'/temp/');

$response_code = $robots->responseCode(); // Код ответа сервера.

session_start(); // Передаем данные через сессию. Даные принимаються в файл Report.php
$_SESSION['RobotsContent'] = $robots_content;
$_SESSION['SearchHost'] = $search_host;
$_SESSION['SearchSiteMap'] = $search_sitemap;
$_SESSION['RobotSize'] = $robotsize;
$_SESSION['ResponseCode'] = $response_code;

echo '<a class="btn btn-primary" href="classes/Report.php" role="button">Сохранить отчет</a>'.
'<a class="btn btn-primary" target="_blank" href="'.$domaine.'" role="button">Просмотреть Robots.txt</a>';

$table = new Table;
$table->viewTable($robots_content, $search_host, $robotsize, $search_sitemap, $response_code); // Выводит результат на екран.