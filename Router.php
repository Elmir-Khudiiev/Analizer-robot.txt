<?php
// Подключаем файлы библиотеки PHPExel
require_once('classes/PHPExcel.php'); // Подключаем класс для работы с excel
require_once('classes/PHPExcel/Writer/Excel5.php'); // Подключаем класс для вывода данных в формате excel
require(__DIR__.'/vendor/autoload.php'); // Файл автозагрузки слассов.
    



$url = $_POST['url']; // Получаем ссылку с формы.

$Robots = new classes\Robots($url);
$RobotsContent = $Robots->robotsContent(); // Контент в "robots.txt"

$Search = new classes\Search($RobotsContent);
$SearchHost = $Search->host(); // Поиск Host: в файле "robots.txt"
$SearchSiteMap = $Search->siteMap(); // Поиск Sitemap: в файле "robots.txt"

$Size = new classes\Size;
$RobotSize = $Size->robotSize($RobotsContent, __DIR__.'/temp/robots.txt'); // Проверка веса файла "robots.txt" в (кб).
unlink(__DIR__.'/temp/robots.txt'); // Удаление временного файла "robots.txt"

$ResponseCode = $Robots->responseCode(); // Код ответа сервера.

session_start();
$_SESSION['RobotsContent'] = $RobotsContent;
$_SESSION['SearchHost'] = $SearchHost;
$_SESSION['SearchSiteMap'] = $SearchSiteMap;
$_SESSION['RobotSize'] = $RobotSize;
$_SESSION['ResponseCode'] = $ResponseCode;

echo '<a class="btn btn-primary" href="classes/Report.php" role="button">Сохранить отчет</a>';

$Table = new classes\Table;
$Table->viewTable($RobotsContent, $SearchHost, $RobotSize, $SearchSiteMap, $ResponseCode); // Выводит результат на екран.