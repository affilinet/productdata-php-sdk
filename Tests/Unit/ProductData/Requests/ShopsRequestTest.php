<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ShopsRequestTest
 */
class ShopsRequestTest extends \PHPUnit_Framework_TestCase
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

        $this->affilinetClient = new \Affilinet\ProductData\AffilinetProductClient(
            [
                'log' => $log,
                'publisher_id' => \Affilinet\Tests\AffilinetTestCredentials::$publisherId,
                'webservice_password' => \Affilinet\Tests\AffilinetTestCredentials::$productWebservicePassword
            ]
        );

    }

    public function testCanAddOnlyOneShopLogo()
    {
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);

        $search->addShopLogoWithSize50px();
        $search->addShopLogoWithSize90px();
        $search->addShopLogoWithSize120px();
        $search->addShopLogoWithSize468px();
        $this->assertEquals('LogoScale=Logo468', $search->serialize());
    }

    public function testOnlyShopMatchingKeyword()
    {
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);

        $search->onlyShopsMatchingKeyword('test');
        $this->assertEquals('Query=test', $search->serialize());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOnlyShopMatchingKeywordMustBeScalar()
    {
        $search = new \Affilinet\ProductData\Requests\ShopsRequest($this->affilinetClient);

        $search->onlyShopsMatchingKeyword(['123']);
    }

}
