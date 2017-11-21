<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class CategoryTest
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructCategory()
    {
        $data = [
            'Id' => '123',
            'IdPath' => 'test',
            'Title' => 'testTitle',
            'TitlePath' => 'te',
            'ProductCount' => '32',

        ];
        $shop = new \Affilinet\ProductData\Responses\ResponseElements\Category($data);

        $this->assertEquals($data['Id'], $shop->getId());
        $this->assertEquals($data['IdPath'], $shop->getIdPath());
        $this->assertEquals($data['Title'], $shop->getName());
        $this->assertEquals($data['TitlePath'], $shop->getNamePath());
        $this->assertEquals($data['ProductCount'], $shop->getProductCount());

    }

}
