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
     * @expectedException \Affilinet\Exceptions\AffilinetWebserviceException
     */
    public function testConstructorThrowsIfNoConfig()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient();

    }

    /**
     * @expectedException \Affilinet\Exceptions\AffilinetWebserviceException
     */
    public function testConstructorThrowsIfNoPublisherId()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient(['webservice_password' => '123456789']);

    }

    /**
     * @expectedException \Affilinet\Exceptions\AffilinetWebserviceException
     */
    public function testConstructorThrowsIfNoProductWebservicePassword()
    {
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient(['publisher_id' => '123']);
    }

    public function testConstructorUsesFallbackData()
    {
        $publisherIDVarName = \Affilinet\ProductData\AffilinetProductClient::PUBLISHER_ID_ENV_NAME;
        $webservicePassVarName = \Affilinet\ProductData\AffilinetProductClient::WEBSERVICE_PASSWORD_ENV_NAME;
        putenv("{$publisherIDVarName}=123");
        putenv("{$webservicePassVarName}=123");
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient();
    }

    public function testGetterSetter()
    {
        $config = [
            'webservice_password' => '123',
            'publisher_id' => '123'
        ];
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient();
        $this->assertEquals($config['webservice_password'], $affilinetClient->getWebservicePassword());
        $this->assertEquals($config['publisher_id'], $affilinetClient->getPublisherId());
    }

    public function testHttpClientExists()
    {
        $config = [
            'webservice_password' => '123',
            'publisher_id' => '123'
        ];
        $affilinetClient = new \Affilinet\ProductData\AffilinetProductClient($config);
        $this->assertInstanceOf(\Affilinet\HttpClient\HttpClientInterface::class, $affilinetClient->getHttpClient());
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
            'webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => $client
        ];
        new \Affilinet\ProductData\AffilinetProductClient($config);
    }

    public function testUsageOfExternalClientLibraryImplementingHttpClientInterface()
    {
        $client = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://www.example.com',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        $http_client = new \Affilinet\HttpClient\GuzzleClient($client);
        $config = [
            'webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => $http_client
        ];
        new \Affilinet\ProductData\AffilinetProductClient($config);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidClientThrows()
    {
        $config = [
            'webservice_password' => '123',
            'publisher_id' => '123',
            'http_client' => '123'
        ];
        new \Affilinet\ProductData\AffilinetProductClient($config);
    }

}
