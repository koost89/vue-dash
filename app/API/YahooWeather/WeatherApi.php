<?php

namespace App\Api\YahooWeather;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 26-11-2018
 * Time: 23:45
 */
class WeatherApi
{
    private $baseUrl = 'ftp://ftp.knmi.nl/pub_weerberichten/tabel_10min_data.html';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function request()
    {
//
        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch) == 0 AND $http === 226) {

            $dom = new DOMDocument();
            $dom->loadHTML($data);

            $tableHeaders = $dom->getElementsByTagName('th');
            $tableDetails = $dom->getElementsByTagName('td');

            //#Get header name of the table
            foreach ($tableHeaders as $tableHeader) {
                $header = explode('(',strtolower(trim($tableHeader->textContent)));
                $tableHeaderList[] = $header[0];
            }

            //#Get row data/detail table without header name as key
            $i = 0;
            $j = 0;

            foreach ($tableDetails as $tableDetail) {
                $tableDetailList[$j][] = trim($tableDetail->textContent);
                $i = $i + 1;
                $j = $i % count($tableHeaderList) === 0 ? $j + 1 : $j;
            }

            //#Get row data/detail table with header name as key and outer array index as row number
            for ($i = 0; $i < count($tableDetailList); $i++) {
                for ($j = 0; $j < count($tableHeaderList); $j++) {
                    $totalList[$i][$tableHeaderList[$j]] = $tableDetailList[$i][$j];
                }
            }
            return $totalList;
        }
    }
}