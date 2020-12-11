<?php

namespace classes;

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
     * @param string $content
     * @param string $fileDirection
     *
     * @return float
     */
    public function getRobotSize(string $content, string $fileDirection): float
    {
        $robot = fopen($fileDirection, 'wb');
        fwrite($robot, $content);
        fclose($robot);

        return round(filesize($fileDirection) / 1024, 3);
    }
}