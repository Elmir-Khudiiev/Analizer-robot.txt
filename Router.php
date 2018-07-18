<?php

// Подключаем файл автозагрузки слассов
require(__DIR__.'/vendor/autoload.php');

// Пространство имен классов.
use classes\Robots;
use classes\Search;
use classes\Size;
use classes\Table;


$url = $_POST['url']; // Получаем ссылку с формы.

$Robots = new Robots($url);
$domaine = $Robots->corectURL();
$RobotsContent = $Robots->robotsContent(); // Контент в "robots.txt"

$Search = new Search($RobotsContent);
$SearchHost = $Search->host(); // Поиск Host: в файле "robots.txt"
$SearchSiteMap = $Search->siteMap(); // Поиск Sitemap: в файле "robots.txt"

$Size = new Size;
$RobotSize = $Size->robotSize($RobotsContent, __DIR__.'/temp/robots.txt'); // Проверка веса файла "robots.txt" в (кб).
unlink(__DIR__.'/temp/robots.txt'); // Удаление временного файла "robots.txt"

$ResponseCode = $Robots->responseCode(); // Код ответа сервера.

session_start(); // Передаем данные через сессию. Даные принимаються в файл Report.php
$_SESSION['RobotsContent'] = $RobotsContent;
$_SESSION['SearchHost'] = $SearchHost;
$_SESSION['SearchSiteMap'] = $SearchSiteMap;
$_SESSION['RobotSize'] = $RobotSize;
$_SESSION['ResponseCode'] = $ResponseCode;

echo '<a class="btn btn-primary" href="classes/Report.php" role="button">Сохранить отчет</a>'.
'<a class="btn btn-primary" target="_blank" href="'.$domaine.'" role="button">Просмотреть Robots.txt</a>';

$Table = new Table;
$Table->viewTable($RobotsContent, $SearchHost, $RobotSize, $SearchSiteMap, $ResponseCode); // Выводит результат на екран.