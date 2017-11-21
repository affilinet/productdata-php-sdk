<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @group integration
 */
class SearchProductsIntegrationTest extends \PHPUnit_Framework_TestCase
{

    use VladaHejda\AssertException;

    /**
     * @var $affilinetClient \Affilinet\ProductData\AffilinetClient
     */
    protected $affilinetClient;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $log = new \Monolog\Logger('testlog');
        $log->pushHandler(new \Monolog\Handler\TestHandler());

        $this->affilinetClient = new \Affilinet\ProductData\AffilinetClient(
            [
                'log' => $log,
                'publisher_id' => \Affilinet\Tests\AffilinetTestCredentials::$publisherId,
                'product_webservice_password' => \Affilinet\Tests\AffilinetTestCredentials::$productWebservicePassword,
            ]
        );

    }

    public function testSend()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addRawQuery('ipod');
        $response = $search->send();
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ProductsResponse::class,$search->send());
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }

    public function testSendViaClient()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addRawQuery('ipod');
        $response = $this->affilinetClient->send($search);
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ProductsResponse::class,$search->send());
        $this->assertEquals($response->jsonSerialize(), $response->toArray());

    }

    /**

     */
    public function test400ServerErrorThrows()
    {
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $search->addFilterQuery('invalidFilterQuery', '123');

        $test = function () use ($search) {
            $search->send();
        };

        $this->assertException(
            $test,
            \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException::class,
            0, 'The given SearchProductsRequest is not valid. - The given SearchProductsRequest is not valid. FilterQuery ‘invalidFilterQuery’ is not supported' );
    }

    public function testSendFindProductId()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);

        $response = $search->find(['123456']);
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ProductsResponse::class,$search->send());
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }

    public function testFindOneReturnsNUllIfNotFound()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $response = $search->findOne('123456');
        $this->assertNull($response);
    }

    public function testFindOneProduct()
    {

        $search = new \Affilinet\ProductData\Requests\ProductsRequest($this->affilinetClient);
        $result = $search->findOne('5495949');

        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Product::class, $result);
    }
}
