<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\Requests;

use Affilinet\ProductData\AffilinetProductClient;
use Affilinet\Responses\ResponseInterface;

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * @param \Affilinet\ProductData\AffilinetProductClient $affilinetClient
     */
    public function __construct(AffilinetProductClient $affilinetClient);

    /**
     * @return ResponseInterface
     */
    public function send();

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getPsr7Request();

    /**
     * Serialize this request for use as URI query string
     * @return string
     */
    public function serialize();

    /**
     * Generate ProductsRequest from URI query string
     *
     * @param $serialized string
     * @return AbstractRequest
     */
    public function unserialize($serialized);

    /**
     * Get the URI to where this request should be sent
     *
     * @return string
     */
    public function getEndpoint();

}
