<?php

// Including class autoloader file
require(__DIR__ . '/vendor/autoload.php');

use classes\Robots;
use classes\Search;
use classes\Table;

if (!empty($_POST['url'])) {
    $robots = new Robots($_POST['url']);
    $search = new Search($robots->getRobotsContent());
    $table = new Table;

    if (!is_dir(__DIR__ . '/temp/') && !mkdir($concurrentDirectory = __DIR__ . '/temp/', 0700) && !is_dir($concurrentDirectory)) {
        throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }


    /**
     * Data transfer via session.
     * The data is received in the Report.php file.
     */
    session_start();
    $_SESSION['robotsContent'] = $search->robotsContent;
    $_SESSION['countHost'] = $search->getHost();
    $_SESSION['countSitemap'] = $search->siteMap();
    $_SESSION['robotsSize'] = $robots->getRobotSize($search->robotsContent, __DIR__ . '/temp/robots.txt');
    $_SESSION['responseServerCode'] = $robots->getResponseServerCode();


    /**
     * Removing the temporary file "/temp/robots.txt"
     */
    unlink(__DIR__ . '/temp/robots.txt');
    rmdir(__DIR__ . '/temp/');


    /**
     * Outputting a table with results
     */
    echo $table->viewTable(
        $robots->getCorrectURL(),
        $_SESSION['robotsContent'],
        $_SESSION['countHost'],
        $_SESSION['countSitemap'],
        $_SESSION['robotSize'],
        $_SESSION['responseServerCode']
    );
} else {
    echo 'URL params is required!';
    die();
}