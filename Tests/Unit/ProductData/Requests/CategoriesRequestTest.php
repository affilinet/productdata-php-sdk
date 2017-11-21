<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * {@inheritDoc}
 */
class CategoriesRequestTest extends \PHPUnit_Framework_TestCase
{

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
                'publisher_id' => 'test',
                'product_webservice_password' => 'test'
            ]
        );

    }

    public function testSetShopId()
    {

        $request = new \Affilinet\ProductData\Requests\CategoriesRequest($this->affilinetClient);
        $request->setShopId(803853);
        $this->assertEquals('ShopId=803853', $request->serialize());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetShopIdThrows()
    {

        $request = new \Affilinet\ProductData\Requests\CategoriesRequest($this->affilinetClient);
        $request->setShopId('123654789');
    }

}
