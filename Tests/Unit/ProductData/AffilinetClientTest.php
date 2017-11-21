<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class AffilinetClientTest
 */
class AffilinetClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testConstructorThrowsIfNoConfig()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient();

    }

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testConstructorThrowsIfNoPublisherId()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient(['product_webservice_password' => '123456789']);

    }

    /**
     * @expectedException \Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException
     */
    public function testConstructorThrowsIfNoProductWebservicePassword()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient(['publisher_id' => '123']);
    }

    public function testConstructorUsesFallbackData()
    {
        $publisherIDVarName = \Affilinet\ProductData\AffilinetClient::PUBLISHER_ID_ENV_NAME;
        $webservicePassVarName = \Affilinet\ProductData\AffilinetClient::PRODUCT_WEBSERVICE_PASSWORD_ENV_NAME;
        putenv("{$publisherIDVarName}=123");
        putenv("{$webservicePassVarName}=123");
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient();
    }

    public function testGetterSetter()
    {
        $config = [
            'product_webservice_password' => '123',
            'publisher_id' => '123'
        ];
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient();
        $this->assertEquals($config['product_webservice_password'], $affilinetClient->getProductDataWebservicePassword());
        $this->assertEquals($config['publisher_id'], $affilinetClient->getPublisherId());
    }

    public function testHttpClientExists()
    {
        $config = [
            'product_webservice_password' => '123',
            'publisher_id' => '123'
        ];
        $affilinetClient = new \Affilinet\ProductData\AffilinetClient($config);
        $this->assertInstanceOf(\Affilinet\ProductData\HttpClient\HttpClientInterface::class, $affilinetClient->getHttpClient());
    }

    public function testUseExternalGuzzleClient()
    {

        $client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://www.example.com',
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);
        $config = [
            'product_webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => $client
        ];
        new \Affilinet\ProductData\AffilinetClient($config);
    }

    public function testUsageOfExternalClientLibraryImplementingHttpClientInterface()
    {
        $client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://www.example.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        $http_client = new \Affilinet\ProductData\HttpClient\GuzzleClient($client);
        $config = [
            'product_webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => $http_client
        ];
        new \Affilinet\ProductData\AffilinetClient($config);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidClientThrows()
    {
        $config = [
            'product_webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => '123'
        ];
        new \Affilinet\ProductData\AffilinetClient($config);
    }

}
