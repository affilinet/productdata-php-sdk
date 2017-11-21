<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ShopTest
 */
class ShopTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructShop()
    {
        $data = [
            'ShopId' => '123',
            'LastUpdate' => '/Date(1365004652303-0000)/',
            'ProductCount' => '133',
            'ProgramId' => '65432',
            'ShopLink' => 'http://example.com/test.php?tr=sd#32',
            'ShopTitle' => 'Shop Name',
            'Logo' => [
                'LogoScale' => 'test',
                'URL' => 'http://www.example.com',
                'Height' => 120,
                'Width' => 60,
            ]
        ];
        $shop = new \Affilinet\ProductData\Responses\ResponseElements\Shop($data);

        $this->assertEquals($data['ShopId'], $shop->getId());
        $this->assertInstanceOf(\DateTime::class, $shop->getLastUpdate());
        $this->assertEquals('1365004652', $shop->getLastUpdate()->getTimestamp());
        $this->assertEquals($data['ProductCount'], $shop->getProductCount());
        $this->assertEquals($data['ProgramId'], $shop->getProgramId());
        $this->assertEquals($data['ShopLink'], $shop->getUrl());
        $this->assertEquals($data['ShopTitle'], $shop->getName());
        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Image::class, $shop->getLogo());
    }

    public function testConstructShopWithoutImage()
    {
        $data = [
            'ShopId' => '123',
            'LastUpdate' => '/Date(1365004652303-0000)/',
            'ProductCount' => '133',
            'ProgramId' => '65432',
            'ShopLink' => 'http://example.com/test.php?tr=sd#32',
            'ShopTitle' => 'Shop Name'
        ];
        $shop = new \Affilinet\ProductData\Responses\ResponseElements\Shop($data);

        $this->assertEquals($data['ShopId'], $shop->getId());
        $this->assertInstanceOf(\DateTime::class, $shop->getLastUpdate());
        $this->assertEquals('1365004652', $shop->getLastUpdate()->getTimestamp());
        $this->assertEquals($data['ProductCount'], $shop->getProductCount());
        $this->assertEquals($data['ProgramId'], $shop->getProgramId());
        $this->assertEquals($data['ShopLink'], $shop->getUrl());
        $this->assertEquals($data['ShopTitle'], $shop->getName());
        $this->assertNull($shop->getLogo());
    }

}
