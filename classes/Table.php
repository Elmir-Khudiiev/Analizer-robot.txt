<?php

namespace classes;

use PHPExcel;
use PHPExcel_Exception;
use PHPExcel_Style_Fill;
use PHPExcel_Writer_Excel5;
use PHPExcel_Writer_Exception;

/**
 * Class Table
 * @package classes
 */
class Table
{
    const REPORT_FILE_NAME = "report.xls";
    /**
     * @var string
     */
    public $robotsUrl;

    /**
     * @var string
     */
    public $robotsContent;

    /**
     * @var int
     */
    public $countHost;

    /**
     * @var float
     */
    public $robotsSize;

    /**
     * @var int
     */
    public $countSitemap;

    /**
     * @var int
     */
    public $responseServerCode;

    /**
     * Table constructor.
     * @param $robotsUrl
     * @param $robotsContent
     * @param $countHost
     * @param $robotsSize
     * @param $countSitemap
     * @param $responseServerCode
     */
    public function __construct(
        string $robotsUrl,
        string $robotsContent,
        int $countHost,
        float $robotsSize,
        int $countSitemap,
        int $responseServerCode
    )
    {
        $this->robotsUrl = $robotsUrl;
        $this->robotsContent = $robotsContent;
        $this->countHost = $countHost;
        $this->robotsSize = $robotsSize;
        $this->countSitemap = $countSitemap;
        $this->responseServerCode = $responseServerCode;
    }

    public function setHeaders(): void
    {
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . self::REPORT_FILE_NAME);
    }

    /**
     * @return string
     */
    public function generateReportHtmlTable(): string
    {
        $resultTable = '
            <div class="button-block">
                <form method="post" action="../router.php">
                    <input type="hidden" value="' . $this->robotsUrl . '" name="url" >
                    <input type="hidden" value="1" name="excel_report" >
                    <button class="btn btn-primary" role="submit">Save report</button>
                </form>
                <a class="btn btn-primary" target="_blank" href="' . $this->robotsUrl . '" role="button">View Robots.txt</a>
            </div>';

        if ($this->robotsContent) {
            $resultTable .= '
            <table class="table">
                <tr class="bold-text">
                    <td>№<br></td>
                    <td>Check name</td>
                    <td>Status</td>
                    <td></td>
                    <td>Current state</td>
                </tr>
                <tr>
                    <td rowspan="2" class="number">1</td>
                    <td rowspan="2">Checking for a robots.txt file
                    </td>
                    <td rowspan="2" class="green">OK</td>
                    <td>Condition</td>
                    <td>Robots.txt file present</td>
                </tr>
                <tr>
                    <td>Recommendations</td>
                    <td>No modifications required</td>
                </tr>';
        } else {
            $resultTable .= '
            <table class="table">
                <tr>
                    <td rowspan="2" class="number">1</td>
                    <td rowspan="2">Checking for a robots.txt file
                    </td>
                    <td rowspan="2" class="red">Error</td>
                    <td>Condition</td>
                    <td>Robots.txt file is missing</td>
                </tr>
                <tr>
                    <td>Recommendations</td>
                    <td>Create a robots.txt file and place it on the site.</td>
                </tr>
            </table>';

            return $resultTable;
        }

        if (!empty($this->countHost)) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">2</td>
                <td rowspan="2">Checking for the Host directive</td>
                <td rowspan="2" class="green">OK</td>
                <td>Condition</td>
                <td>Host directive specified</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>No modifications required</td>
            </tr>';

            if ($this->countHost > 1) {
                $resultTable .= '
                    <tr>
                        <td rowspan="2" class="number">3</td>
                        <td rowspan="2">Checking the number of Host directives written in the file.</td>
                        <td rowspan="2" class="red">Error</td>
                        <td>Condition</td>
                        <td>The file contains several Host directives</td>
                    </tr>
                    <tr>
                        <td>Recommendations</td>
                        <td>The Host directive must be specified only once in the file. It is necessary to remove all additional Host directives and leave only 1, correct and corresponding to the main site mirror.</td>
                    </tr>';
            } else {
                $resultTable .= '
                    <tr>
                        <td rowspan="2" class="number">3</td>
                        <td rowspan="2">Checking the number of Host directives written in the file.</td>
                        <td rowspan="2" class="green">OK</td>
                        <td>Condition</td>
                        <td>The file contains 1 Host directive</td>
                    </tr>
                    <tr>
                        <td>Recommendations</td>
                        <td>No modifications required</td>
                    </tr>';
            }
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">2</td>
                <td rowspan="2">Checking for the Host directive</td>
                <td rowspan="2" class="red">Error</td>
                <td>Condition</td>
                <td>Host directive is missing in robots.txt file</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>In order for the search engines to know which version of the site is the main mirror, it is necessary to register the address of the main mirror in the Host directive. At the moment, this is not spelled out. You need to add the Host directive to your robots.txt file. The Host directive is specified in the file 1 time, after all the rules.</td>
            </tr>';
        }

        if ($this->robotsSize < 32) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">4</td>
                <td rowspan="2">Checking robots.txt file size</td>
                <td rowspan="2" class="green">OK</td>
                <td>Condition</td>
                <td>The robots.txt file size is ' . $this->robotsSize . ' kb, what is within acceptable limits.</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>No modifications required</td>
            </tr>';
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">4</td>
                <td rowspan="2">Checking robots.txt file size</td>
                <td rowspan="2" class="red">Error</td>
                <td>Condition</td>
                <td>The robots.txt file size is ' . $this->robotsSize . ' kb, which exceeds the permissible rate.</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>The maximum size for a robots.txt file is 32 kb. You need to edit your robots.txt file so that its size does not exceed 32 KB.</td>
            </tr>';
        }

        if (!empty($this->countSitemap)) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">5</td>
                <td rowspan="2">Checking the Sitemap directive</td>
                <td rowspan="2" class="green">OK</td>
                <td>Condition</td>
                <td>Sitemap directive specified</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>No modifications required</td>
            </tr>';
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">5</td>
                <td rowspan="2">Checking the Sitemap directive</td>
                <td rowspan="2" class="red">Error</td>
                <td>Condition</td>
                <td>Sitemap directive not specified in robots.txt file</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>Add the Sitemap directive to the robots.txt file.</td>
            </tr>';
        }

        if ($this->responseServerCode === 200) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">6</td>
                <td rowspan="2">Checking the server response code for a robots.txt file</td>
                <td rowspan="2" class="green">OK</td>
                <td>Condition</td>
                <td>Robots.txt file returns server response code 200</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>No modifications required</td>
            </tr>';
        } else {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">6</td>
                <td rowspan="2">Checking the server response code for a robots.txt file</td>
                <td rowspan="2" class="red">Error</td>
                <td>Condition</td>
                <td>When accessing the robots.txt file, the server returns a response code ' . $this->responseServerCode . '</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>The robots.txt file must return a response code of 200, otherwise the file will not be processed. It is necessary to configure the site so that when accessing the robots.txt file, the server returns a response code of 200.</td>
            </tr>
            </table>';
        }

        return $resultTable;
    }

    /**
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function generateReportXlsTable()
    {
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex();
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Report robots.txt');

        // Adding table headers
        $sheet->setCellValue("A1", '№');
        $sheet->setCellValue("B1", 'Check name');
        $sheet->setCellValue("C1", 'Status');
        $sheet->setCellValue("E1", 'Current state');

        // Change the color of the table header cell
        $sheet->getStyle('A1:E1')->getFill()->setFillType(
            PHPExcel_Style_Fill::FILL_SOLID
        );
        $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('#6ba9b8');

        // Determining the width of the columns
        $sheet->getColumnDimension()->setWidth(8);
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

        // Merge cells
        foreach ($cells as $cell) {
            $sheet->mergeCells($cell);
            $sheet->getStyle($cell)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle($cell)
                ->getFill()
                ->getStartColor()
                ->setRGB('cacaca');
        }
        foreach ($cells2 as $cell2) {
            $sheet->mergeCells($cell2);
        }

        // Checking the consistency of data before displaying the result.
        if ($this->robotsContent) {
            $sheet->setCellValue("A3", '1');
            $sheet->setCellValue("B3", 'Checking for a robots.txt file');
            $sheet->setCellValue("C3", 'Ok');
            $sheet->getStyle('C3')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C3')
                ->getFill()
                ->getStartColor()
                ->setRGB('2bff48');

            $sheet->setCellValue("D3", 'Condition');
            $sheet->setCellValue("D4", 'Recommendations');
            $sheet->setCellValue("E3", 'Robots.txt file present');
            $sheet->setCellValue("E4", 'No modifications required');
        } else {
            $sheet->setCellValue("A3", '1');
            $sheet->setCellValue("B3", 'Checking for a robots.txt file');
            $sheet->setCellValue("C3", 'Error');
            $sheet->getStyle('C3')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C3')
                ->getFill()
                ->getStartColor()
                ->setRGB('f00000');

            $sheet->setCellValue("D3", 'Condition');
            $sheet->setCellValue("D4", 'Recommendations');
            $sheet->setCellValue("E3", 'Robots.txt file is missing');
            $sheet->setCellValue("E4", 'Programmer: Create a robots.txt file and place it on the site');
        }

        if (!empty($this->countHost)) {
            $sheet->setCellValue("A6", '2');
            $sheet->setCellValue("B6", 'Checking the Host Directive Specification');
            $sheet->setCellValue("C6", 'Ok');
            $sheet->getStyle('C6')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C6')
                ->getFill()
                ->getStartColor()
                ->setRGB('2bff48');

            $sheet->setCellValue("D6", 'Condition');
            $sheet->setCellValue("D7", 'Recommendations');
            $sheet->setCellValue("E6", 'Host directive specified');
            $sheet->setCellValue("E7", 'No modifications required');


            if ($this->countHost > 1) {
                $sheet->setCellValue("A9", '3');
                $sheet->setCellValue("B9", 'Checking the number of Host directives written in the file');
                $sheet->setCellValue("C9", 'Ok');
                $sheet->getStyle('C9')
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

                $sheet->getStyle('C9')
                    ->getFill()
                    ->getStartColor()
                    ->setRGB('2bff48');

                $sheet->setCellValue("D9", 'Condition');
                $sheet->setCellValue("D10", 'Recommendations');
                $sheet->setCellValue("E9", 'The file contains 1 Host directive');
                $sheet->setCellValue("E10", 'No modifications required');
            } else {
                $sheet->setCellValue("A9", '3');
                $sheet->setCellValue("B9", 'Checking the number of Host directives written in the file');
                $sheet->setCellValue("C9", 'Error');
                $sheet->getStyle('C9')
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

                $sheet->getStyle('C9')
                    ->getFill()
                    ->getStartColor()
                    ->setRGB('f00000');

                $sheet->setCellValue("D9", 'Condition');
                $sheet->setCellValue("D10", 'Recommendations');
                $sheet->setCellValue("E9", 'The file contains several Host directives');
                $sheet->setCellValue("E10", 'Programmer: The Host directive must be specified in the file only 1 time. It is necessary to remove all additional Host directives and leave only 1, correct and corresponding to the main site mirror');
            }
        } else {
            $sheet->setCellValue("A6", '2');
            $sheet->setCellValue("B6", 'Checking the Host Directive Specification');
            $sheet->setCellValue("C6", 'Error');
            $sheet->getStyle('C6')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C6')
                ->getFill()
                ->getStartColor()
                ->setRGB('f00000');

            $sheet->setCellValue("D6", 'Condition');
            $sheet->setCellValue("D7", 'Recommendations');
            $sheet->setCellValue("E6", 'Host directive is missing in robots.txt file');
            $sheet->setCellValue("E7", 'Programmer: In order for the search engines to know which version of the site is the main mirror, it is necessary to register the address of the main mirror in the Host directive. This is not spelled out at the moment. You need to add the Host directive to your robots.txt file. The Host directive is specified in the file 1 time, after all the rules.');
        }

        if ($this->robotsSize < 32) {
            $sheet->setCellValue("A12", '4');
            $sheet->setCellValue("B12", 'Checking robots.txt file size');
            $sheet->setCellValue("C12", 'Ok');
            $sheet->getStyle('C12')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C12')
                ->getFill()
                ->getStartColor()
                ->setRGB('2bff48');

            $sheet->setCellValue("D12", 'Condition');
            $sheet->setCellValue("D13", 'Recommendations');
            $sheet->setCellValue("E12", 'The robots.txt file size is ' . $this->robotsSize . ' kb, what is within acceptable limits');
            $sheet->setCellValue("E13", 'No modifications required');
        } else {
            $sheet->setCellValue("A12", '4');
            $sheet->setCellValue("B12", 'Checking robots.txt file size');
            $sheet->setCellValue("C12", 'Error');
            $sheet->getStyle('C12')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C12')
                ->getFill()
                ->getStartColor()
                ->setRGB('f00000');

            $sheet->setCellValue("D12", 'Condition');
            $sheet->setCellValue("D13", 'Recommendations');
            $sheet->setCellValue("E12", 'The robots.txt file size is ' . $this->robotsSize . ' kb, which exceeds the permissible rate');
            $sheet->setCellValue("E13", 'Programmer: The maximum size of a robots.txt file is 32 kb. You need to edit your robots.txt file so that its size does not exceed 32 Kb');
        }

        if (!empty($this->countSitemap)) {
            $sheet->setCellValue("A15", '5');
            $sheet->setCellValue("B15", 'Checking the Sitemap directive');
            $sheet->setCellValue("C15", 'Ok');
            $sheet->getStyle('C15')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C15')
                ->getFill()
                ->getStartColor()
                ->setRGB('2bff48');

            $sheet->setCellValue("D15", 'Condition');
            $sheet->setCellValue("D16", 'Recommendations');
            $sheet->setCellValue("E15", 'Sitemap directive specified');
            $sheet->setCellValue("E16", 'No modifications required');
        } else {
            $sheet->setCellValue("A15", '5');
            $sheet->setCellValue("B15", 'Checking the Sitemap directive');
            $sheet->setCellValue("C15", 'Error');
            $sheet->getStyle('C15')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C15')
                ->getFill()
                ->getStartColor()
                ->setRGB('f00000');

            $sheet->setCellValue("D15", 'Condition');
            $sheet->setCellValue("D16", 'Recommendations');
            $sheet->setCellValue("E15", 'Sitemap directive not specified in robots.txt file');
            $sheet->setCellValue("E16", 'Programmer: Add Sitemap directive to robots.txt file');
        }

        if ($this->responseServerCode === 200) {
            $sheet->setCellValue("A18", '6');
            $sheet->setCellValue("B18", 'Checking the server response code for a robots.txt file');
            $sheet->setCellValue("C18", 'Ok');
            $sheet->getStyle('C18')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C18')
                ->getFill()
                ->getStartColor()
                ->setRGB('2bff48');

            $sheet->setCellValue("D18", 'Condition');
            $sheet->setCellValue("D19", 'Recommendations');
            $sheet->setCellValue("E18", 'Robots.txt file gives server response code 200');
            $sheet->setCellValue("E19", 'No modifications required');
        } else {
            $sheet->setCellValue("A18", '6');
            $sheet->setCellValue("B18", 'Checking the server response code for a robots.txt file');
            $sheet->setCellValue("C18", 'Error');
            $sheet->getStyle('C18')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

            $sheet->getStyle('C18')
                ->getFill()
                ->getStartColor()
                ->setRGB('f00000');

            $sheet->setCellValue("D18", 'Condition');
            $sheet->setCellValue("D19", 'Recommendations');
            $sheet->setCellValue("E18", 'When accessing the robots.txt file, the server returns a response code ' . $this->responseServerCode);
            $sheet->setCellValue("E19", 'Programmer: The robots.txt file must return a response code of 200, otherwise the file will not be processed. It is necessary to configure the site so that the server returns a 200 response code when accessing the robots.txt file.');
        }

        return $xls;

    }

    /**
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Writer_Exception
     */
    public function saveReportFile()
    {
        // Set Headers
        $this->setHeaders();

        // Displaying the contents of the file
        $objectWriter = new PHPExcel_Writer_Excel5($this->generateReportXlsTable());
        $objectWriter->save('php://output');
    }
}