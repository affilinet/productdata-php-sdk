<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GuzzleHttp\Psr7;

/**
 * Class SearchProductsResponseTest
 */
class CategoriesResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    /**
     * {@inheritDoc}
     */
    public function setup()
    {
        $responseString = file_get_contents(dirname(__FILE__).'/../../Mocks/CategoriesResponse.txt');
        $stream = Psr7\stream_for($responseString);
        $this->response = new Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);

    }

    public function testCategoriesResponseObjectConstructor()
    {
        $response = new \Affilinet\ProductData\Responses\CategoriesResponse($this->response);
        $this->assertEquals(7, $response->pageSize());
        $this->assertEquals(1, $response->pageNumber());
        $this->assertEquals(1, $response->totalPages());
        $this->assertEquals(7, $response->totalRecords());
        $this->assertEquals(0, $response->getProgramId());
        $this->assertEquals('affilinet', $response->getProgramName());
        $this->assertEquals('affilinet', $response->getShopName());
        $this->assertEquals(0, $response->getShopId());
        $this->assertEquals(0, $response->getShopId());
    }

    public function testGetCategories()
    {
        $response = new \Affilinet\ProductData\Responses\CategoriesResponse($this->response);
        $this->assertEquals($response->categories(), $response->getCategories());
        foreach ($response->getCategories() as $category) {
            $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Category::class, $category);
        }
    }

}
