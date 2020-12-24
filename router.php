<?php
// Including class autoloader file
require(__DIR__ . '/vendor/autoload.php');

use classes\Robots;
use classes\Table;

if (empty($_POST['url'])) {
    echo 'URL params is required!';
    die();
}

try {
    $robots = new Robots($_POST['url']);

    $table = new Table(
        $robots->getCorrectURL(),
        $robots->getRobotsContent(),
        $robots->getCountHost(),
        $robots->getRobotSize(__DIR__ . '/temp/'),
        $robots->getCountSitemap(),
        $robots->getResponseServerCode()
    );

    echo $table->generateReportHtmlTable();
} catch (Exception $exception) {
    echo $exception->getMessage();
}

if (!empty($_POST['excel_report'])) {
    try {
        $table->saveReportFile();
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}