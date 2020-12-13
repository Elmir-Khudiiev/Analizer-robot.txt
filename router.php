<?php

// Including class autoloader file
require(__DIR__ . '/vendor/autoload.php');

use classes\Robots;
use classes\Table;

const TEMP_ROBOTS_DIR = __DIR__ . '/temp/';

if (!empty($_POST['url'])) {
    $robots = new Robots($_POST['url']);
    $table = new Table;


    /**
     * Data transfer via session.
     * The data is received in the Report.php file.
     *
     * Outputting a table with results
     */
    session_start();
    echo $table->generateReportTable(
        $robots->getCorrectURL(),
        $_SESSION['robotsContent'] = $robots->getRobotsContent(),
        $_SESSION['countHost'] = $robots->getCountHost(),
        $_SESSION['countSitemap'] = $robots->getCountSitemap(),
        $_SESSION['robotsSize'] = $robots->getRobotSize(TEMP_ROBOTS_DIR),
        $_SESSION['responseServerCode'] = $robots->getResponseServerCode()
    );
} else {
    echo 'URL params is required!';
    die();
}