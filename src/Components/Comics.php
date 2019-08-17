<?php

namespace App\Components;

use Curl\Curl;
use App\Components\SourceRequest;


/**
 * Class for SpaceX api
 * Parse api, returning the array of data
 */
final class Comics extends SourceRequest
{
    //defines the endpoint to call on space server
    const API_URL = 'https://xkcd.com/';
    const API_URL_END = '/info.0.json';

    /**
     * Total requests
     * @return array
     * @throws \Exception
     */
    public function process(): array
    {
        $result = [];
        try {
            $i = 0;
            while ($this->curl->http_status_code == 200 || $i == 0) {
                $i++;

                // crutch to fix 404 error on request https://xkcd.com/404/info.0.json
                if ($i == 404) {
                    $i++;
                }

                $this->curl->get(self::API_URL . $i . self::API_URL_END);
                if ($this->curl->http_status_code == 200) {
                    $row = json_decode($this->curl->getResponse(), true);
                    $result[$row['year']][] = [
                        'number' => $row['num'],
                        'date' => date('Y-m-d', mktime(0, 0, 0, $row['month'], $row['day'], $row['year'])),
                        'name' => isset($row['title']) ? $row['title'] : '',
                        'link' => isset($row['link']) ? $row['link'] : '',
                        'details' => isset($row['alt']) ? $row['alt'] : '',
                    ];
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}