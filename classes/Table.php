<?php

namespace classes;

/**
 * Class Table
 * @package classes
 */
class Table
{

    /**
     * @param string $robotsUrl
     * @param string $robotsContent
     * @param int    $countHost
     * @param float  $robotsSize
     * @param int    $countSitemap
     * @param int    $responseServerCode
     *
     * @return string
     */
    public function viewTable(
        string $robotsUrl,
        string $robotsContent,
        int    $countHost,
        int    $countSitemap,
        float  $robotsSize,
        int    $responseServerCode
    ): string
    {
        $resultTable = '<a class="btn btn-primary" href="classes/Report.php" role="button">Save report</a>' .
            '<a class="btn btn-primary" target="_blank" href="' . $robotsUrl . '" role="button">View Robots.txt</a>';

        if ($robotsContent) {
            $resultTable .= '
            <table class="table">
                <tr class="bold-text">
                    <td>№<br></td>
                    <td>Название проверки</td>
                    <td>Статус</td>
                    <td></td>
                    <td>Текущее состояние</td>
                </tr>
                <tr>
                    <td rowspan="2" class="number">1</td>
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
            $resultTable .= '
            <table class="table">
                <tr>
                    <td rowspan="2" class="number">1</td>
                    <td rowspan="2">Проверка наличия файла robots.txt
                    </td>
                    <td rowspan="2" class="red">Ошибка</td>
                    <td>Состояние</td>
                    <td>Файл robots.txt отсутствует</td>
                </tr>
                <tr>
                    <td>Рекомендации</td>
                    <td>Создать файл robots.txt и разместить его на сайте.</td>
                </tr>
            </table>';

            return $resultTable;
        }

        if (!empty($countHost)) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">2</td>
                <td rowspan="2">Проверка указания директивы Host</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Директива Host указана</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';

            if ($countHost > 1) {
                $resultTable .= '
                    <tr>
                        <td rowspan="2" class="number">3</td>
                        <td rowspan="2">Проверка количества директив Host, прописанных в файле</td>
                        <td rowspan="2" class="red">Ошибка</td>
                        <td>Состояние</td>
                        <td>В файле прописано несколько директив Host</td>
                    </tr>
                    <tr>
                        <td>Рекомендации</td>
                        <td>Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта.</td>
                    </tr>';
            } else {
                $resultTable .= '
                    <tr>
                        <td rowspan="2" class="number">3</td>
                        <td rowspan="2">Проверка количества директив Host, прописанных в файле</td>
                        <td rowspan="2" class="green">OK</td>
                        <td>Состояние</td>
                        <td>В файле прописана 1 директива Host</td>
                    </tr>
                    <tr>
                        <td>Рекомендации</td>
                        <td>Доработки не требуются</td>
                    </tr>';
            }
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">2</td>
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

        if ($robotsSize < 32) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">4</td>
                <td rowspan="2">Проверка размера файла robots.txt</td>
                <td rowspan="2" class="green">OK</td>
                <td>Состояние</td>
                <td>Размер файла robots.txt составляет ' . $robotsSize . ' кб, что находится в пределах допустимой нормы</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Доработки не требуются</td>
            </tr>';
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">4</td>
                <td rowspan="2">Проверка размера файла robots.txt</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>Размера файла robots.txt составляет ' . $robotsSize . ' кб, что превышает допустимую норму</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб.</td>
            </tr>';
        }

        if (!empty($countSitemap)) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">5</td>
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
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">5</td>
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

        if ($responseServerCode === 200) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">6</td>
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
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">6</td>
                <td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
                <td rowspan="2" class="red">Ошибка</td>
                <td>Состояние</td>
                <td>При обращении к файлу robots.txt сервер возвращает код ответа ' . $responseServerCode . '</td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td>Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200.</td>
            </tr>
            </table>';
        }

        return $resultTable;
    }
}