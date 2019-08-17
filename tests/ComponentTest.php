<?php

use PHPUnit\Framework\TestCase;
use App\Components\Space;
use App\Components\Comics;

class ConponentTest extends TestCase
{
    private $sourceProvider;

    /**
     * Setup object for testing trait
     */
    protected function setUp()
    {
        $this->sourceProvider = new \App\Service\SourceService();
    }

    protected function tearDown()
    {
        $this->sourceProvider = null;
    }

    public function testSourceProvider()
    {
        $limit = 2;
        $result = $this->sourceProvider->getProvider('space', 2013, $limit);
        $this->assertCount($limit, $result);

        $limit = 3;
        $year = 2017;
        $result = $this->sourceProvider->getProvider('space', $year, $limit);
        $this->assertCount($limit, $result);
        $this->assertEquals(35, $result[0]['number']);

        $result = $this->sourceProvider->getProvider('comics', 2015, 1);
        $this->assertEquals(1468, $result[0]['number']);
    }

}