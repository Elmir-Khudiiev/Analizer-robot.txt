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
        $sum_host = preg_match('#Host#', $this->robots);
        return $sum_host;
    }

    public function siteMap() // Выполняем поиск Sitemap: в файле robots.txt
    {
        $sum_sitemap = preg_match('#Sitemap:#', $this->robots);
        return $sum_sitemap;
    }
}