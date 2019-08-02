<?php

// Подключаем файлы библиотеки PHPExel
require_once('PHPExcel.php'); // Подключаем класс для работы с excel
require_once('PHPExcel/Writer/Excel5.php'); // Подключаем класс для вывода данных в формате excel

session_start();
$robots_content = $_SESSION['RobotsContent'];
$search_host = $_SESSION['SearchHost'];
$search_sitemap = $_SESSION['SearchSiteMap'];
$robot_size = $_SESSION['RobotSize'];
$response_code = $_SESSION['ResponseCode'];

// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Отчет robots.txt');

// Добавляем заголовки таблицы
$sheet->setCellValue("A1", '№');
$sheet->setCellValue("B1", 'Название проверки');
$sheet->setCellValue("C1", 'Статус');
$sheet->setCellValue("E1", 'Текущее состояние');

// Изминяем цвет ячеяк заголовков таблицы
$sheet->getStyle('A1:E1')->getFill()->setFillType(
    PHPExcel_Style_Fill::FILL_SOLID
);
$sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('#6ba9b8');

// Опредиляем ширину столбцов
$sheet->getColumnDimension('A')->setWidth(8);
$sheet->getColumnDimension('B')->setWidth(55);
$sheet->getColumnDimension('C')->setWidth(12);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(65);


$cells = ['A2:E2', 'A5:E5', 'A8:E8', 'A11:E11', 'A14:E14', 'A17:E17', 'A20:E20'];
$cells2 = [
    'A3:A4', 'A6:A7', 'A9:A10', 'A12:A13', 'A15:A16', 'A18:A19',
    'B3:B4', 'B6:B7', 'B9:B10', 'B12:B13', 'B15:B16', 'B18:B19',
    'C3:C4', 'C6:C7', 'C9:C10', 'C12:C13', 'C15:C16', 'C18:C19'
];

// Объединяем ячейки
foreach ($cells as $cell) {
    $sheet->mergeCells($cell);
    $sheet->getStyle($cell)->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle($cell)->getFill()->getStartColor()->setRGB('cacaca');
}
foreach ($cells2 as $cell2) {
    $sheet->mergeCells($cell2);
}

// Проверка соответствия данных перед выводом результата.
if ($robots_content == true) {
    $sheet->setCellValue("A3", '1');
    $sheet->setCellValue("B3", 'Проверка наличия файла robots.txt');
    $sheet->setCellValue("C3", 'Ok');
    $sheet->getStyle('C3')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C3')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D3", 'Состояние');
    $sheet->setCellValue("D4", 'Рекомендации');
    $sheet->setCellValue("E3", 'Файл robots.txt присутствует');
    $sheet->setCellValue("E4", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A3", '1');
    $sheet->setCellValue("B3", 'Проверка наличия файла robots.txt');
    $sheet->setCellValue("C3", 'Ошибка');
    $sheet->getStyle('C3')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C3')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D3", 'Состояние');
    $sheet->setCellValue("D4", 'Рекомендации');
    $sheet->setCellValue("E3", 'Файл robots.txt отсутствует');
    $sheet->setCellValue("E4", 'Программист: Создать файл robots.txt и разместить его на сайте');
}

if ($search_host > 0) {
    $sheet->setCellValue("A6", '2');
    $sheet->setCellValue("B6", 'Проверка указания директивы Host');
    $sheet->setCellValue("C6", 'Ok');
    $sheet->getStyle('C6')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C6')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D6", 'Состояние');
    $sheet->setCellValue("D7", 'Рекомендации');
    $sheet->setCellValue("E6", 'Директива Host указана');
    $sheet->setCellValue("E7", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A6", '2');
    $sheet->setCellValue("B6", 'Проверка указания директивы Host');
    $sheet->setCellValue("C6", 'Ошибка');
    $sheet->getStyle('C6')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C6')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D6", 'Состояние');
    $sheet->setCellValue("D7", 'Рекомендации');
    $sheet->setCellValue("E6", 'В файле robots.txt не указана директива Host');
    $sheet->setCellValue("E7", 'Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.');
}

if ($search_host == 1) {
    $sheet->setCellValue("A9", '3');
    $sheet->setCellValue("B9", 'Проверка количества директив Host, прописанных в файле');
    $sheet->setCellValue("C9", 'Ok');
    $sheet->getStyle('C9')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C9')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D9", 'Состояние');
    $sheet->setCellValue("D10", 'Рекомендации');
    $sheet->setCellValue("E9", 'В файле прописана 1 директива Host');
    $sheet->setCellValue("E10", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A9", '3');
    $sheet->setCellValue("B9", 'Проверка количества директив Host, прописанных в файле');
    $sheet->setCellValue("C9", 'Ошибка');
    $sheet->getStyle('C9')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C9')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D9", 'Состояние');
    $sheet->setCellValue("D10", 'Рекомендации');
    $sheet->setCellValue("E9", 'В файле прописано несколько директив Host');
    $sheet->setCellValue("E10", 'Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта');
}

if ($robot_size < 32) {
    $sheet->setCellValue("A12", '4');
    $sheet->setCellValue("B12", 'Проверка размера файла robots.txt');
    $sheet->setCellValue("C12", 'Ok');
    $sheet->getStyle('C12')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C12')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D12", 'Состояние');
    $sheet->setCellValue("D13", 'Рекомендации');
    $sheet->setCellValue("E12", 'Размер файла robots.txt составляет ' . $robot_size . ' кб, что находится в пределах допустимой нормы');
    $sheet->setCellValue("E13", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A12", '4');
    $sheet->setCellValue("B12", 'Проверка размера файла robots.txt');
    $sheet->setCellValue("C12", 'Ошибка');
    $sheet->getStyle('C12')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C12')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D12", 'Состояние');
    $sheet->setCellValue("D13", 'Рекомендации');
    $sheet->setCellValue("E12", 'Размера файла robots.txt составляет ' . $robot_size . ' кб, что превышает допустимую норму');
    $sheet->setCellValue("E13", 'Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб');
}

if ($search_sitemap > 0) {
    $sheet->setCellValue("A15", '5');
    $sheet->setCellValue("B15", 'Проверка указания директивы Sitemap');
    $sheet->setCellValue("C15", 'Ok');
    $sheet->getStyle('C15')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C15')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D15", 'Состояние');
    $sheet->setCellValue("D16", 'Рекомендации');
    $sheet->setCellValue("E15", 'Директива Sitemap указана');
    $sheet->setCellValue("E16", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A15", '5');
    $sheet->setCellValue("B15", 'Проверка указания директивы Sitemap');
    $sheet->setCellValue("C15", 'Ошибка');
    $sheet->getStyle('C15')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C15')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D15", 'Состояние');
    $sheet->setCellValue("D16", 'Рекомендации');
    $sheet->setCellValue("E15", 'В файле robots.txt не указана директива Sitemap');
    $sheet->setCellValue("E16", 'Программист: Добавить в файл robots.txt директиву Sitemap');
}

if ($response_code == 200) {
    $sheet->setCellValue("A18", '6');
    $sheet->setCellValue("B18", 'Проверка кода ответа сервера для файла robots.txt');
    $sheet->setCellValue("C18", 'Ok');
    $sheet->getStyle('C18')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C18')->getFill()->getStartColor()->setRGB('2bff48');
    $sheet->setCellValue("D18", 'Состояние');
    $sheet->setCellValue("D19", 'Рекомендации');
    $sheet->setCellValue("E18", 'Файл robots.txt отдаёт код ответа сервера 200');
    $sheet->setCellValue("E19", 'Доработки не требуются');
} else {
    $sheet->setCellValue("A18", '6');
    $sheet->setCellValue("B18", 'Проверка кода ответа сервера для файла robots.txt');
    $sheet->setCellValue("C18", 'Ошибка');
    $sheet->getStyle('C18')->getFill()->setFillType(
        PHPExcel_Style_Fill::FILL_SOLID
    );
    $sheet->getStyle('C18')->getFill()->getStartColor()->setRGB('f00000');
    $sheet->setCellValue("D18", 'Состояние');
    $sheet->setCellValue("D19", 'Рекомендации');
    $sheet->setCellValue("E18", 'При обращении к файлу robots.txt сервер возвращает код ответа ' . $response_code);
    $sheet->setCellValue("E19", 'Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200.');
}

// Выводим HTTP-заголовки
header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=report.xls");

// Выводим содержимое файла
$obj_writer = new PHPExcel_Writer_Excel5($xls);
$obj_writer->save('php://output');