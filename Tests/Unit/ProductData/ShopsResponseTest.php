<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GuzzleHttp\Psr7;

/**
 * Class ShopsResponseTest
 */
class ShopsResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setup()
    {
        $responseString = file_get_contents(dirname(__FILE__).'/../../Mocks/ShopsResponse.txt');
        $stream = Psr7\stream_for($responseString);
        $this->response = new Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);

    }

    public function testShopsResponseObjectConstructor()
    {
        $response = new \Affilinet\ProductData\Responses\ShopsResponse($this->response);
        $this->assertEquals(10, $response->pageSize());
        $this->assertEquals(1, $response->pageNumber());
        $this->assertEquals(3, $response->totalPages());
        $this->assertEquals(26, $response->totalRecords());
        $this->assertEquals($response->getShops(), $response->shops());
    }

    public function testGetShops()
    {
        $response = new \Affilinet\ProductData\Responses\ShopsResponse($this->response);

        foreach ($response->getShops() as $shop) {
            $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Shop::class, $shop);
        }
    }

}
