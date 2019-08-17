<?php

namespace App\Components;

use Curl\Curl;

/**
 * Class for api requests
 */
abstract class SourceRequest
{
    /**
     * Curl
     */
    protected $curl;

    /**
     * Component constructor.
     */
    public function __construct()
    {
        $this->curl = new Curl();
        $this->curl->setOpt(CURLOPT_TIMEOUT, 180);
        $this->curl->setOpt(CURLOPT_CONNECTTIMEOUT, 10);
        $this->curl->setOpt(CURLOPT_ENCODING, 'UTF-8');
        $this->curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
    }

    /**
     * Component destructor.
     */
    public function __destruct()
    {
        $this->curl->close();
    }

    /**
     * Force Extending class to define this method
     */
    abstract function process();

}