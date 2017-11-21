<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class FacetTest
 */
class FacetTest extends PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $data = [
            'FacetField' => 'TestFacet',
            'FacetValues' => [],
        ];
        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);

        $this->assertEquals($data['FacetField'], $facet->getName());
        $this->assertEmpty($facet->getValues());
        $this->assertTrue(is_array($facet->getValues()));
    }

    public function testGenerateFacetShopCategoryPathFacet()
    {
        $data = [
            'FacetField' => 'ShopCategoryPathFacet',
            'FacetValues' => [
                [
                    'FacetValueName' => '803853^Babysitter^803853^Babysitter',
                    'FacetValueCount' => 541
                ],
                [
                    'FacetValueName' => '13733461^Kleider & Hosen^13733456 > 13733457 > 13733461^Dessous > Für Frauen > Kleider & Hosen',
                    'FacetValueCount' => 6541
                ]
            ],
        ];
        $expectedFacetValueNames = [
            'Babysitter', 'Dessous > Für Frauen > Kleider & Hosen'
        ];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);

        $this->assertEquals($data['FacetField'], $facet->getName());
        $this->assertTrue(is_array($facet->getValues()));
        $this->assertNotEmpty($facet->getValues());

        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($data['FacetValues'][$i]['FacetValueName'], $facetValue->getValue());
            $this->assertEquals($expectedFacetValueNames[$i], $facetValue->getDisplayValue());
            $this->assertEquals($data['FacetValues'][$i]['FacetValueCount'], $facetValue->getResultCount());
            $i++;
        }
    }

    public function testGenerateNormalFacet()
    {
        $data = [
            'FacetField' => 'test',
            'FacetValues' => [
                [
                    'FacetValueName' => 'test23',
                    'FacetValueCount' => 54123
                ],
                [
                    'FacetValueName' => 'testb',
                    'FacetValueCount' => 65423
                ]
            ],
        ];
        $expectedFacetValueNames = [
            'test23', 'testb'
        ];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);

        $this->assertEquals($data['FacetField'], $facet->getName());
        $this->assertTrue(is_array($facet->getValues()));
        $this->assertNotEmpty($facet->getValues());

        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($data['FacetValues'][$i]['FacetValueName'], $facetValue->getValue());
            $this->assertEquals($expectedFacetValueNames[$i], $facetValue->getDisplayValue());
            $this->assertEquals($data['FacetValues'][$i]['FacetValueCount'], $facetValue->getResultCount());
            $i++;
        }
    }

    public function testGenerateSerializedProductsRequestForFacets()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'test',
            'FacetValues' => [
                [
                    'FacetValueName' => 'aaaaa',
                    'FacetValueCount' => 54123
                ],
                [
                    'FacetValueName' => 'bbbbb',
                    'FacetValueCount' => 65423
                ]
            ],
        ];
        $expectedSerializedProductRequests = ['FQ=test%3Aaaaaa', 'FQ=test%3Abbbbb'];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

    public function testGenerateSerializedProductsRequestForFacetShopName()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'ShopName',
            'FacetValues' => [
                [
                    'FacetValueName' => 'aaaaa',
                    'FacetValueCount' => 54123
                ],
                [
                    'FacetValueName' => 'bbbbb',
                    'FacetValueCount' => 65423
                ]
            ],
        ];
        $expectedSerializedProductRequests = ['', ''];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

    public function testGenerateSerializedProductsRequestForFacetProgramId()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'ProgramId',
            'FacetValues' => [
                [
                    'FacetValueName' => 'aaaaa',
                    'FacetValueCount' => 235345
                ],
                [
                    'FacetValueName' => 'bbbbb',
                    'FacetValueCount' => 5675675
                ]
            ],
        ];
        $expectedSerializedProductRequests = ['', ''];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

    public function testGenerateSerializedProductsRequestForFacetShopId()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'ShopId',
            'FacetValues' => [
                [
                    'FacetValueName' => '234',
                    'FacetValueCount' => 235345
                ],
                [
                    'FacetValueName' => '432',
                    'FacetValueCount' => 5675675
                ]
            ],
        ];
        $expectedSerializedProductRequests = ['ShopIds=234&ShopIdMode=Include', 'ShopIds=432&ShopIdMode=Include'];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

    public function testGenerateSerializedProductsRequestForFacetShopCategoryId()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'ShopCategoryId',
            'FacetValues' => [
                [
                    'FacetValueName' => '123123',
                    'FacetValueCount' => 235345
                ],
                [
                    'FacetValueName' => '234234',
                    'FacetValueCount' => 5675675
                ]
            ],
        ];
        $expectedSerializedProductRequests = [
            'CategoryIds=123123&ExcludeSubCategories=false&UseAffilinetCategories=false',
            'CategoryIds=234234&ExcludeSubCategories=false&UseAffilinetCategories=false'];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

    public function testGenerateSerializedProductsRequestForFacetAffilinetCategoryId()
    {

        $request = new \Affilinet\ProductData\Requests\ProductsRequest(new \Affilinet\ProductData\AffilinetClient(['publisher_id' => 'test', 'product_webservice_password' => 'test']));

        $data = [
            'FacetField' => 'AffilinetCategoryId',
            'FacetValues' => [
                [
                    'FacetValueName' => '1231',
                    'FacetValueCount' => 235345
                ],
                [
                    'FacetValueName' => '234234',
                    'FacetValueCount' => 5675675
                ]
            ],
        ];
        $expectedSerializedProductRequests = [
            'CategoryIds=1231&ExcludeSubCategories=false&UseAffilinetCategories=true',
            'CategoryIds=234234&ExcludeSubCategories=false&UseAffilinetCategories=true'];

        $facet = new \Affilinet\ProductData\Responses\ResponseElements\Facet($data);
        $i = 0;
        foreach ($facet->getValues() as $facetValue) {
            $this->assertEquals($expectedSerializedProductRequests[$i], $facetValue->generateSerializedProductsRequest($request));
            $this->assertEquals('?'.$expectedSerializedProductRequests[$i], $facetValue->generateQueryString($request));
            $i++;
        }

    }

}
