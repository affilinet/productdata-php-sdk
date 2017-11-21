<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ProductTest
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $price = [
            'Currency' => 'EUR',
            'DisplayPrice' => ' 10.00 EUR ',
            'DisplayShipping' => ' 12.00 EUR ',
            'DisplayBasePrice' => ' 31.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 23.00,
                'PricePrefix' => ' asfsb ',
                'Price' => 3.00,
                'PriceSuffix' => ' EUgsfR ',
            ],
            'ShippingDetails' => [
                'ShippingPrefix' => ' a4sb ',
                'Shipping' => 5.00,
                'ShippingSuffix' => ' EgmUR ',
            ],
            'BasePriceDetails' => [
                'BasePricePrefix' => ' a2b ',
                'BasePrice' => 6.00,
                'BasePriceSuffix' => ' EdUR ',
            ]
        ];

        $data = [
            'Score' => 0.0012654987,
            'ArticleNumber' => "abs123456789",
            'LastShopUpdate' => '/Date(1365004652303-0500)/',
            'LastProductChange' => '/Date(1365004652303-0200)/',
            'ProductId' => 32165478,
            'ShopId' => 3216544,
            'ShopTitle' => 'ACME SHOP',
            'ProductName' => 'ACME PRODUCT',
            'Description' => 'THIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test text',
            'DescriptionShort' => 'THIS IST A WONDERFUL test text',
            'ShopCategoryId' => 123,
            'AffilinetCategoryId' => 'string1',
            'ShopCategoryPath' => 'string2',
            'AffilinetCategoryPath' => 'string3',
            'ShopCategoryIdPath' => 'string4',
            'AffilinetCategoryIdPath' => 'string5',
            'Deeplink1' => 'http://www.example.com/deeplink1',
            'Deeplink2' => 'http://www.example.com/deeplink2',
            'Brand' => 'brand',
            'Manufacturer' => 'Manufacturer',
            'Distributor' => 'Distributor',
            'EAN' => 'EAN1233654',
            'Keywords' => 'Keywords, tests, shops',
            'ProgramId' => 123456,
            'PriceInformation' => $price,

            "Images" => [
                [
                    0 => [
                        "ImageScale" => "OriginalImage",
                        "URL" => "http://example.com.de/sdfsdf.jpg",
                        "Width" => 400,
                        "Height" => 500
                    ],
                    1 => [
                        "ImageScale" => "OriginalImage",
                        "URL" => "http://example.com.de/123.jpg",
                        "Width" => 450,
                        "Height" => 560
                    ]
                ]
            ],
            "Logos" => [
                [
                    0 => [
                        "LogoScale" => "Logo90",
                        "URL" => "http://example.com.de/3r41qadf.jpg",
                        "Width" => 90,
                        "Height" => 640
                    ],
                    1 => [
                        "LogoScale" => "Logo468",
                        "URL" => "http://example.com.de/fsdfsdf.jpg",
                        "Width" => 468,
                        "Height" => 450
                    ]
                ]
            ],
            "Properties" => [
                0 => [
                    'PropertyName' => 'testprop',
                    'PropertyValue' => 'testValue'
                ],
                2 => [
                    'PropertyName' => 'testprop3',
                    'PropertyValue' => 'testValue322'
                ]
            ]
        ];

        $expectedProperties = [
            'testprop' => 'testValue',
            'testprop3' => 'testValue322',
        ];

        $product = new \Affilinet\ProductData\Responses\ResponseElements\Product($data);
        $this->assertEquals($data['ArticleNumber'], $product->getArticleNumber());
        $this->assertEquals($data['Score'], $product->getScore());

        $this->assertInstanceOf(\DateTime::class, $product->getLastShopUpdate());
        $this->assertInstanceOf(\DateTime::class, $product->getLastProductChange());

        $this->assertEquals($data['ProductId'], $product->getProductId());
        $this->assertEquals($data['ShopId'], $product->getShopId());
        $this->assertEquals($data['ShopTitle'], $product->getShopTitle());
        $this->assertEquals($data['ProductName'], $product->getProductName());
        $this->assertEquals($data['Description'], $product->getDescription());
        $this->assertEquals($data['DescriptionShort'], $product->getDescriptionShort());
        $this->assertEquals($data['ShopCategoryId'], $product->getShopCategoryId());
        $this->assertEquals($data['AffilinetCategoryId'], $product->getAffilinetCategoryId());
        $this->assertEquals($data['ShopCategoryPath'], $product->getShopCategoryPath());
        $this->assertEquals($data['AffilinetCategoryPath'], $product->getAffilinetCategoryPath());
        $this->assertEquals($data['ShopCategoryIdPath'], $product->getShopCategoryIdPath());
        $this->assertEquals($data['AffilinetCategoryIdPath'], $product->getAffilinetCategoryIdPath());
        $this->assertEquals($data['Deeplink1'], $product->getDeeplink());
        $this->assertEquals($data['Deeplink2'], $product->getAlternativeDeeplink());
        $this->assertEquals($data['Deeplink2'], $product->getAlternativeDeeplink(false));
        $this->assertEquals($data['Deeplink2'], $product->getAlternativeDeeplink(true));
        $this->assertTrue($product->hasAlternativeDeeplink());

        $this->assertEquals($data['Brand'], $product->getBrand());
        $this->assertEquals($data['Manufacturer'], $product->getManufacturer());
        $this->assertEquals($data['Distributor'], $product->getDistributor());
        $this->assertEquals($data['EAN'], $product->getEAN());
        $this->assertEquals($data['Keywords'], $product->getKeywords());
        $this->assertEquals($data['ProgramId'], $product->getProgramId());

        $this->assertInstanceOf(\Affilinet\ProductData\Responses\ResponseElements\Price::class, $product->getPriceInformation());
        $this->assertFalse($product->hasProperty('dasgibtsnicht'));

        $i = 0;
        foreach ($product->getImages() as $image) {
            $this->assertEquals($data['Images'][0][$i]['Height'], $image->getHeight());
            $this->assertEquals($data['Images'][0][$i]['Width'], $image->getWidth());
            $this->assertEquals($data['Images'][0][$i]['ImageScale'], $image->getScaleName());
            $this->assertEquals($data['Images'][0][$i]['URL'], $image->getUrl());
            $i++;
        }

        $i = 0;
        foreach ($product->getLogos() as $logo) {
            $this->assertEquals($data['Logos'][0][$i]['Height'], $logo->getHeight());
            $this->assertEquals($data['Logos'][0][$i]['Width'], $logo->getWidth());
            $this->assertEquals($data['Logos'][0][$i]['LogoScale'], $logo->getScaleName());
            $this->assertEquals($data['Logos'][0][$i]['URL'], $logo->getUrl());
            $i++;
        }
        $this->assertTrue($product->hasProperty('testprop'));
        $this->assertEquals($data['Properties'][0]['PropertyValue'], $product->getProperty('testprop'));

        $this->assertEquals($expectedProperties, $product->getProperties());
        $this->assertEquals(null, $product->getProperty('iDoNotExist'));

    }

    public function testConstructorWithOneImageOnly()
    {
        $price = [
            'Currency' => 'EUR',
            'DisplayPrice' => ' 10.00 EUR ',
            'DisplayShipping' => ' 12.00 EUR ',
            'DisplayBasePrice' => ' 31.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 23.00,
                'PricePrefix' => ' asfsb ',
                'Price' => 3.00,
                'PriceSuffix' => ' EUgsfR ',
            ],
            'ShippingDetails' => [
                'ShippingPrefix' => ' a4sb ',
                'Shipping' => 5.00,
                'ShippingSuffix' => ' EgmUR ',
            ],
            'BasePriceDetails' => [
                'BasePricePrefix' => ' a2b ',
                'BasePrice' => 6.00,
                'BasePriceSuffix' => ' EdUR ',
            ]
        ];

        $data = [
            'Score' => 0.0012654987,
            'ArticleNumber' => "abs123456789",
            'LastShopUpdate' => '/Date(1365004652303-0500)/',
            'LastProductChange' => '/Date(1365004652303-0200)/',
            'ProductId' => 32165478,
            'ShopId' => 3216544,
            'ShopTitle' => 'ACME SHOP',
            'ProductName' => 'ACME PRODUCT',
            'Description' => 'THIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test text',
            'DescriptionShort' => 'THIS IST A WONDERFUL test text',
            'ShopCategoryId' => 123,
            'AffilinetCategoryId' => 'string1',
            'ShopCategoryPath' => 'string2',
            'AffilinetCategoryPath' => 'string3',
            'ShopCategoryIdPath' => 'string4',
            'AffilinetCategoryIdPath' => 'string5',
            'Deeplink1' => 'http://www.example.com/deeplink1',
            'Deeplink2' => 'http://www.example.com/deeplink2',
            'Brand' => 'brand',
            'Manufacturer' => 'Manufacturer',
            'Distributor' => 'Distributor',
            'EAN' => 'EAN1233654',
            'Keywords' => 'Keywords, tests, shops',
            'ProgramId' => 123456,
            'PriceInformation' => $price,

            "Images" => [

                    0 => [
                        "ImageScale" => "OriginalImage",
                        "URL" => "http://example.com.de/sdfsdf.jpg",
                        "Width" => 400,
                        "Height" => 500
                    ],

            ],
            "Logos" => [
                    0 => [
                        "LogoScale" => "Logo90",
                        "URL" => "http://example.com.de/3r41qadf.jpg",
                        "Width" => 90,
                        "Height" => 640
                    ],

            ],

        ];

        $product = new \Affilinet\ProductData\Responses\ResponseElements\Product($data);

        $i = 0;
        foreach ($product->getImages() as $image) {
            $this->assertEquals($data['Images'][$i]['Height'], $image->getHeight());
            $this->assertEquals($data['Images'][$i]['Width'], $image->getWidth());
            $this->assertEquals($data['Images'][$i]['ImageScale'], $image->getScaleName());
            $this->assertEquals($data['Images'][$i]['URL'], $image->getUrl());
            $i++;
        }

        $i = 0;
        foreach ($product->getLogos() as $logo) {
            $this->assertEquals($data['Logos'][$i]['Height'], $logo->getHeight());
            $this->assertEquals($data['Logos'][$i]['Width'], $logo->getWidth());
            $this->assertEquals($data['Logos'][$i]['LogoScale'], $logo->getScaleName());
            $this->assertEquals($data['Logos'][$i]['URL'], $logo->getUrl());
            $i++;
        }

    }

    public function testDeeplinkWithProductDataAddedToCartMethod()
    {

        $price = [
            'Currency' => 'EUR',
            'DisplayPrice' => ' 10.00 EUR ',
            'DisplayShipping' => ' 12.00 EUR ',
            'DisplayBasePrice' => ' 31.00 EUR ',
            'PriceDetails' => [
                'PriceOld' => 23.00,
                'PricePrefix' => ' asfsb ',
                'Price' => 3.00,
                'PriceSuffix' => ' EUgsfR ',
            ],
            'ShippingDetails' => [
                'ShippingPrefix' => ' a4sb ',
                'Shipping' => 5.00,
                'ShippingSuffix' => ' EgmUR ',
            ],
            'BasePriceDetails' => [
                'BasePricePrefix' => ' a2b ',
                'BasePrice' => 6.00,
                'BasePriceSuffix' => ' EdUR ',
            ]
        ];

        $data = [
            'Score'                    => 0.0012654987,
            'ArticleNumber'            => "abs123456789",
            'LastShopUpdate'           => '/Date(1365004652303-0500)/',
            'LastProductChange'        => '/Date(1365004652303-0200)/',
            'ProductId'                => 32165478,
            'ShopId'                   => 3216544,
            'ShopTitle'                => 'ACME SHOP',
            'ProductName'              => 'ACME PRODUCT',
            'Description'              => 'THIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test textTHIS IST A WONDERFUL test text',
            'DescriptionShort'         => 'THIS IST A WONDERFUL test text',
            'ShopCategoryId'           => 123,
            'AffilinetCategoryId'      => 'string1',
            'ShopCategoryPath'         => 'string2',
            'AffilinetCategoryPath'    => 'string3',
            'ShopCategoryIdPath'       => 'string4',
            'AffilinetCategoryIdPath'  => 'string5',
            'Deeplink1'                => 'http://www.example.com/deeplink1',

            'Brand'                    => 'brand',
            'Manufacturer'             => 'Manufacturer',
            'Distributor'              => 'Distributor',
            'EAN'                      => 'EAN1233654',
            'Keywords'                 => 'Keywords, tests, shops',
            'ProgramId'                => 123456,
            'PriceInformation'         => $price,

        ];

        $product = new \Affilinet\ProductData\Responses\ResponseElements\Product($data);
        $this->assertEquals(null, $product->getAlternativeDeeplink());
        $this->assertEquals($data['Deeplink1'], $product->getAlternativeDeeplink(true));

    }
}
