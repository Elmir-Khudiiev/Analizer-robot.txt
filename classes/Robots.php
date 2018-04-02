<?php

namespace classes;

class Robots
{
    public $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function corectURL() // Валидируем введенные ссылки.
    {
        // Опредиляем введен ли протокол передачи.
        $corectURL = preg_match('#http#', $this->url);
        if($corectURL == 0) {
            $this->url = 'http://'.$this->url;
        }

        // Определяем домен
        $segment = explode('/', $this->url);
        $this->url = 'http://'.$segment[2].'/robots.txt';

        return $this->url;
    }

    public function robotsContent() // Получаем все данные с Robots.txt
    {
        $curl = curl_init($this->corectURL());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $robots = curl_exec($curl);

        return $robots;
    }

    public function responseCode() // Получаем код ответа сервера.
    {
        $headers = get_headers($this->corectURL());
        $code = explode(' ', $headers[0]);

        return $code[1];
    }
}