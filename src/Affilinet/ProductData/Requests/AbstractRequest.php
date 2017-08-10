<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\AffilinetClient;
use GuzzleHttp\Psr7\Request;

/**
 * Base Request Class
 */
abstract class AbstractRequest implements RequestInterface
{

    /**
     * @var $affilinetClient AffilinetClient
     */
    protected $affilinetClient;

    /**
     * @var $queryParams array
     */
    protected $queryParams;

    /**
     * @param \Affilinet\ProductData\AffilinetClient $affilinetClient
     */
    public function __construct(AffilinetClient $affilinetClient)
    {
        $this->affilinetClient = $affilinetClient;
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getPsr7Request()
    {
        return new Request('GET', $this->getEndpoint() . '?' . $this->serializeWithCredentials());
    }

    /**
     * @return string
     */
    protected function serializeWithCredentials()
    {
        $query = $this->queryParams;
        $query['PublisherId'] = $this->getAffilinetClient()->getPublisherId();
        $query['Password'] = $this->getAffilinetClient()->getProductDataWebservicePassword();

        return http_build_query($query);
    }

    /**
     * @return AffilinetClient
     */
    public function getAffilinetClient()
    {
        return $this->affilinetClient;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        $query = $this->queryParams;
        if (empty($query)) return '';
        return http_build_query($query, '' , '&');
    }

    /**
     * @param  string $serialized
     * @return $this
     */
    public function unserialize($serialized)
    {
        $this->queryParams = [];
        parse_str($serialized, $this->queryParams);

        return $this;
    }
}
