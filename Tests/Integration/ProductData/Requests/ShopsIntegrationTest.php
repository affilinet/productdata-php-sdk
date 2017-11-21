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
class ShopsIntegrationTest extends \PHPUnit_Framework_TestCase
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
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);
        $search->page('1');
        $search->pageSize('10');
        $response = $search->send();
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ShopsResponse::class,$search->send());
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }

    public function testSendViaClient()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);
        $search->page(2);
        $search->pageSize(20);
        $response = $this->affilinetClient->send($search);
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ShopsResponse::class,$search->send());
        $this->assertEquals($response->jsonSerialize(), $response->toArray());

    }

    public function testOnlyShopsMatchingKeyword()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);
        $search->onlyShopsMatchingKeyword('maxdome');
        $response = $search->send();
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ShopsResponse::class,$search->send());
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }


    public function testShopLogo()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);
        $search->onlyShopsMatchingKeyword('maxdome');
        $search->addShopLogoWithSize50px();
        $response = $search->send();

        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ShopsResponse::class,$search->send());
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        foreach ($response->getShops() as $shop ){

            foreach ($shop->getLogo() as $image) {
                $this->assertEquals('Logo50', $image->getScaleName());
            };
        }
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }


    public function testOnlyShopsUpdatedAfter()
    {
        $this->setUp();
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);
        $search->onlyShopsUpdatedAfter(new DateTime('last month'));
        $response = $search->send();
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ShopsResponse::class,$search->send());
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        $this->assertEquals($response->jsonSerialize(), $response->toArray());
    }

}
