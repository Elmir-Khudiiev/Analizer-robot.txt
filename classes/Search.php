<?php

namespace classes;

/**
 * Class Search
 * @package classes
 */
class Search
{
    /**
     * @var string
     */
    public $robotsContent;

    /**
     * Search constructor.
     * @param $robotsContent
     */
    public function __construct(string $robotsContent)
    {
        $this->robotsContent = $robotsContent;
    }

    /**
     * Number of "Host" values in "robots.txt"
     *
     * @return int
     */
    public function getHost(): int
    {
        return substr_count('Host:', $this->robotsContent);
    }

    /**
     * Number of "Sitemap" in "robots.txt"
     *
     * @return int
     */
    public function siteMap(): int
    {
        return substr_count('Sitemap:', $this->robotsContent);
    }
}