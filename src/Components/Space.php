<?php

namespace App\Components;

use Curl\Curl;
use App\Components\SourceRequest;


/**
 * Class for SpaceX api
 * Parse api, returning the array of data
 */
final class Space extends SourceRequest
{
    //defines the endpoint to call on space server
    const API_URL = 'https://api.spacexdata.com/v2/launches';

    /**
     * Total requests
     * @return array
     * @throws \Exception
     */
    public function process(): array
    {
        $result = [];
        try {
            $this->curl->get(self::API_URL);
            if ($this->curl->http_status_code == 200) {
                $rows = json_decode($this->curl->getResponse(), true);
                foreach ($rows as $row) {
                    $result[date('Y', strtotime($row['launch_date_utc']))][] = [
                        'number' => $row['flight_number'],
                        'date' => date('Y-m-d', strtotime($row['launch_date_utc'])),
                        'name' => isset($row['mission_name']) ? $row['mission_name'] : '',
                        'link' => isset($row['links']['article_link']) ? $row['links']['article_link'] : '',
                        'details' => isset($row['details']) ? $row['details'] : '',
                    ];
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Parse
     */
}