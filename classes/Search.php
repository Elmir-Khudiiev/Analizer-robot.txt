<?php

namespace classes;

class Search
{
    public $robots;

    public function __construct($robots)
    {
        $this->robots = $robots;
    }

    public function host() // Выполняем поиск Host: в файле robots.txt
    {
        $sumHost = preg_match('#Host#', $this->robots);
        return $sumHost;
    }

    public function siteMap() // Выполняем поиск Sitemap: в файле robots.txt
    {
        $sumSiteMap = preg_match('#Sitemap:#', $this->robots);
        return $sumSiteMap;
    }
}