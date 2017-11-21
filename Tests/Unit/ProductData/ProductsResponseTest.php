<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GuzzleHttp\Psr7;

/**
 * Class ProductsResponseTest
 */
class ProductsResponseTest extends \PHPUnit_Framework_TestCase
{
    private $response;

    /**
     * {@inheritDoc}
     */
    public function setup()
    {
        $responseString = file_get_contents(dirname(__FILE__).'/../../Mocks/SearchProductsResponse.txt');
        $stream = Psr7\stream_for($responseString);
        $this->response = new Psr7\Response(200, ['Content-Type' => 'application/json'], $stream);

    }

    public function testProductsResponseObjectConstructor()
    {
        $searchProductsResponse = new \Affilinet\ProductData\Responses\ProductsResponse($this->response);
        $this->assertEquals(10, $searchProductsResponse->pageSize());
        $this->assertEquals(1, $searchProductsResponse->pageNumber());
        $this->assertEquals(11, $searchProductsResponse->totalPages());
        $this->assertEquals(102, $searchProductsResponse->totalRecords());
    }

    public function testGetProducts()
    {
        $searchProductsResponse = new \Affilinet\ProductData\Responses\ProductsResponse($this->response);
        $this->assertEquals($searchProductsResponse->products(), $searchProductsResponse->getProducts());
        foreach ($searchProductsResponse->products() as $product) {
            $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Product::class, $product);
        }
    }

    public function testGetFacets()
    {
        $searchProductsResponse = new \Affilinet\ProductData\Responses\ProductsResponse($this->response);
        $this->assertEquals($searchProductsResponse->getFacets(), $searchProductsResponse->facets());

        foreach ($searchProductsResponse->facets() as $facet) {
            $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Facet::class, $facet);
        }

    }

}
