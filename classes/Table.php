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
    public function generateReportTable(
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

        if (!empty($countHost)) {
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

            if ($countHost > 1) {
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

        if ($robotsSize < 32) {
            $resultTable .= '
            <tr>
                <td rowspan="2" class="number">4</td>
                <td rowspan="2">Checking robots.txt file size</td>
                <td rowspan="2" class="green">OK</td>
                <td>Condition</td>
                <td>The robots.txt file size is ' . $robotsSize . ' kb, what is within acceptable limits.</td>
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
                <td>The robots.txt file size is ' . $robotsSize . ' kb, which exceeds the permissible rate.</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>The maximum size for a robots.txt file is 32 kb. You need to edit your robots.txt file so that its size does not exceed 32 KB.</td>
            </tr>';
        }

        if (!empty($countSitemap)) {
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

        if ($responseServerCode === 200) {
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
                <td>When accessing the robots.txt file, the server returns a response code ' . $responseServerCode . '</td>
            </tr>
            <tr>
                <td>Recommendations</td>
                <td>The robots.txt file must return a response code of 200, otherwise the file will not be processed. It is necessary to configure the site so that when accessing the robots.txt file, the server returns a response code of 200.</td>
            </tr>
            </table>';
        }

        return $resultTable;
    }
}