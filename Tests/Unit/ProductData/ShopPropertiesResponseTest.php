<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GuzzleHttp\Psr7;

/**
 * Class ShopPropertiesResponseTest
 */
class ShopPropertiesResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setup()
    {
        $responseString = file_get_contents(dirname(__FILE__).'/../../Mocks/ShopPropertiesResponse.txt');
        $stream = Psr7\stream_for($responseString);
        $this->response = new Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);

    }

    public function testShopPropertiesResponseObjectConstructor()
    {
        $response = new \Affilinet\ProductData\Responses\ShopPropertiesResponse($this->response);
        $this->assertEquals(640, $response->getShopId());
        $this->assertEquals(2, $response->totalProperties());
        $this->assertEquals(2, $response->totalRecords());
        $this->assertEquals(2, $response->totalProperties());
        $this->assertEquals(new \Affilinet\ProductData\Responses\ResponseElements\ShopProperty('CF_location', 8460), $response->getProperty('CF_location'));
        $this->assertEquals(new \Affilinet\ProductData\Responses\ResponseElements\ShopProperty('CF_zipcode', 1233), $response->getProperty('CF_zipcode'));
        $this->assertEquals(0, $response->getProperty('123654'));

        $this->assertTrue($response->hasProperty('CF_location'));
        $this->assertTrue($response->hasProperty('CF_zipcode'));
        $this->assertTrue(is_array($response->getProperties()));
        $this->assertEquals(2, count($response->getProperties()));
    }

}
