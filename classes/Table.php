<?php 

namespace classes;

class Table
{
    public function viewTable($robots_content, $search_host, $robot_size, $search_sitemap, $response_code)
    {
        if($robots_content == true) {
            echo '
            <link rel="stylesheet" href="components/css/mane.css">
            <table class="table">
            <tr class="boldtext">
                <td>№<br></td>
                <td>Название проверки</td>
                <td>Статус</td>
                <td></td>
                <td>Текущее состояние</td>
            </tr>
            <tr>
                <td rowspan="2"class="number">1</td>
                <td rowspan="2">Проверка наличия файла robots.txt
                </td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Файл robots.txt присутствует</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <link rel="stylesheet" href="components/css/mane.css">
            <table class="table">
            <tr>
                <td rowspan="2"class="number">1</td>
                <td rowspan="2">Проверка наличия файла robots.txt
                </td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>Файл robots.txt отсутствует</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Создать файл robots.txt и разместить его на сайте.</td>
            </tr></table>';
            exit();
        }
        
        if($search_host > 0) {
            echo '
            <tr>
                <td rowspan="2"class="number">2</td>
                <td rowspan="2">Проверка указания директивы Host</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Директива Host указана</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <tr>
                <td rowspan="2"class="number">2</td>
                <td rowspan="2">Проверка указания директивы Host</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>В файле robots.txt не указана директива Host</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.</td>
            </tr>';
        }
        
        if($search_host == 1) {
            echo '
            <tr>
                <td rowspan="2"class="number">3</td>
                <td rowspan="2">Проверка количества директив Host, прописанных в файле</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>В файле прописана 1 директива Host</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <tr>
                <td rowspan="2"class="number">3</td>
                <td rowspan="2">Проверка количества директив Host, прописанных в файле</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>В файле прописано несколько директив Host</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта.</td>
            </tr>';
        }
        
        if($robot_size < 32) {
            echo '
            <tr>
                <td rowspan="2"class="number">4</td>
                <td rowspan="2">Проверка размера файла robots.txt</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Размер файла robots.txt составляет '.$robot_size.' кб, что находится в пределах допустимой нормы</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <tr>
                <td rowspan="2"class="number">4</td>
                <td rowspan="2">Проверка размера файла robots.txt</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>Размера файла robots.txt составляет '.$robot_size.' кб, что превышает допустимую норму</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб.</td>
            </tr>';
        }
        
        if($search_sitemap > 0) {
            echo '
            <tr>
                <td rowspan="2"class="number">5</td>
                <td rowspan="2">Проверка указания директивы Sitemap</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Директива Sitemap указана</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <tr>
                <td rowspan="2"class="number">5</td>
                <td rowspan="2">Проверка указания директивы Sitemap</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>В файле robots.txt не указана директива Sitemap</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Добавить в файл robots.txt директиву Sitemap.</td>
            </tr>';
        }
        
        if($response_code == 200) {
            echo '
            <tr>
                <td rowspan="2"class="number">6</td>
                <td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Файл robots.txt отдаёт код ответа сервера 200</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            echo '
            <tr>
                <td rowspan="2"class="number">6</td>
                <td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>При обращении к файлу robots.txt сервер возвращает код ответа '.$response_code.'</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200.</td>
            </tr>
            </table>';
        }
    }
}