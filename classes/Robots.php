<?php

namespace classes;

use RuntimeException;

/**
 * Class Robots
 * @package classes
 */
class Robots
{
    /**
     * @var string
     */
    public $url;

    /**
     * Robots constructor.
     *
     * @param $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Link validation
     *
     * @return string
     */
    public function getCorrectURL(): string
    {
        // Determine if the transfer protocol has been introduced.
        $getCorrectURL = false !== strpos($this->url, "http");

        if (empty($getCorrectURL)) {
            $this->url = 'https://' . $this->url;
        }

        // Determine the domain
        $segment = explode('/', $this->url);
        $this->url = 'https://' . $segment[2] . '/robots.txt';

        return $this->url;
    }

    /**
     * Returns the content of the "robots.txt" file
     *
     * @return bool|string
     */
    public function getRobotsContent()
    {
        $curl = curl_init($this->getCorrectURL());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($curl);
    }

    /**
     * Get the server response code.
     *
     * @return int
     */
    public function getResponseServerCode(): int
    {
        $headers = get_headers($this->getCorrectURL());
        $code = explode(' ', $headers[0]);

        return $code[1];
    }

    /**
     * @param string $tempDir
     *
     * @return float
     */
    public function getRobotSize(string $tempDir): float
    {
        if (!is_dir($tempDir) && !mkdir($concurrentDirectory = $tempDir, 0700) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $robot = fopen($tempDir . 'robots.txt', 'wb');
        fwrite($robot, $this->getRobotsContent());
        fclose($robot);

        $robotsSize = round(filesize($tempDir . 'robots.txt') / 1024, 3);

        /**
         * Removing the temporary file "/temp/robots.txt"
         */
        unlink($tempDir . 'robots.txt');
        rmdir($tempDir);

        return $robotsSize;
    }

    /**
     * Number of "Host" values in "robots.txt"
     *
     * @return int
     */
    public function getCountHost(): int
    {
        return substr_count($this->getRobotsContent(), 'Host:');
    }

    /**
     * Number of "Sitemap" in "robots.txt"
     *
     * @return int
     */
    public function getCountSitemap(): int
    {
        return substr_count($this->getRobotsContent(), 'Sitemap:');
    }
}