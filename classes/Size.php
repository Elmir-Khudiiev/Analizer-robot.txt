<?php

namespace classes;

class Size
{
    public function robotSize($content, $adres)
    {
        $robot = fopen($adres, 'w');
        fwrite($robot, $content);
        fclose($robot);

        return filesize($adres)/1000;
    }
}