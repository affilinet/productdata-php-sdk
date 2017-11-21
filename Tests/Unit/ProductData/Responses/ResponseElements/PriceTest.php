<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class PriceTest
 */
class PriceTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructPriceWithMinimalData()
    {
        $data = [
            'Currency' => 'EUR',
            'DisplayPrice' => ' 1.00 EUR ',
            'DisplayShipping' => ' 1.00 EUR ',
            'DisplayBasePrice' => ' 1.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 2.00,
                'PricePrefix' => ' ab ' ,
                'Price' => 1.00,
                'PriceSuffix' => ' EUR ',
            ]
        ];
        $price = new \Affilinet\ProductData\Responses\ResponseElements\Price($data);

        $this->assertEquals($data['Currency'], $price->getCurrency());
        $this->assertEquals($data['DisplayPrice'], $price->getDisplayPrice());
        $this->assertEquals($data['DisplayShipping'], $price->getDisplayShipping());
        $this->assertEquals($data['DisplayBasePrice'], $price->getDisplayBasePrice());

        $this->assertEquals($data['PriceDetails']['PriceOld'], $price->getPriceOld());
        $this->assertEquals($data['PriceDetails']['PricePrefix'], $price->getPricePrefix());
        $this->assertEquals($data['PriceDetails']['PriceSuffix'], $price->getPriceSuffix());
        $this->assertEquals($data['PriceDetails']['Price'], $price->getPrice());
    }

    public function testConstructPriceWithAllData()
    {
        $data = [
            'Currency' => 'EeUR',
            'DisplayPrice' => ' 10.00 EUR ',
            'DisplayShipping' => ' 12.00 EUR ',
            'DisplayBasePrice' => ' 31.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 23.00,
                'PricePrefix' => ' asfsb ' ,
                'Price' => 3.00,
                'PriceSuffix' => ' EUgsfR ',
            ],
            'ShippingDetails' => [
                'ShippingPrefix' => ' a4sb ' ,
                'Shipping' => 5.00,
                'ShippingSuffix' => ' EgmUR ',
            ],
            'BasePriceDetails' => [
                'BasePricePrefix' => ' a2b ' ,
                'BasePrice' => 6.00,
                'BasePriceSuffix' => ' EdUR ',
            ]
        ];
        $price = new \Affilinet\ProductData\Responses\ResponseElements\Price($data);

        $this->assertEquals($data['ShippingDetails']['ShippingPrefix'], $price->getShippingPricePrefix());
        $this->assertEquals($data['ShippingDetails']['Shipping'], $price->getShippingPrice());
        $this->assertEquals($data['ShippingDetails']['ShippingSuffix'], $price->getShippingPriceSuffix());

        $this->assertEquals($data['BasePriceDetails']['BasePricePrefix'], $price->getBasePricePrefix());
        $this->assertEquals($data['BasePriceDetails']['BasePrice'], $price->getBasePrice());
        $this->assertEquals($data['BasePriceDetails']['BasePriceSuffix'], $price->getBasePriceSuffix());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConstructThrowsIfNoCurrency()
    {
        $data = [
            'DisplayPrice' => ' 1.00 EUR ',
            'DisplayShipping' => ' 1.00 EUR ',
            'DisplayBasePrice' => ' 1.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 2.00,
                'PricePrefix' => ' ab ' ,
                'Price' => 1.00,
                'PriceSuffix' => ' EUR ',
            ]
        ];
        $price = new \Affilinet\ProductData\Responses\ResponseElements\Price($data);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConstructThrowsIfNoDisplayPrice()
    {
        $data = [
            'Currency' => 'EUR',
            'DisplayShipping' => ' 1.00 EUR ',
            'DisplayBasePrice' => ' 1.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 2.00,
                'PricePrefix' => ' ab ' ,
                'Price' => 1.00,
                'PriceSuffix' => ' EUR ',
            ]
        ];
        $price = new \Affilinet\ProductData\Responses\ResponseElements\Price($data);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConstructThrowsIfNoPriceDetails()
    {
        $data = [
            'Currency' => 'EUR',
            'DisplayShipping' => ' 1.00 EUR ',
            'DisplayBasePrice' => ' 1.00 EUR ',
            'PriceDetails' => [],

        ];
        $price = new \Affilinet\ProductData\Responses\ResponseElements\Price($data);
    }

}
