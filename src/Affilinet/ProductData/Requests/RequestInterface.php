<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\AffilinetClient;
use Affilinet\ProductData\Responses\ResponseInterface;

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * @param \Affilinet\ProductData\AffilinetClient $affilinetClient
     */
    public function __construct(AffilinetClient $affilinetClient);

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
     * @return ProductsRequest
     */
    public function unserialize($serialized);

    /**
     * Get the URI to where this request should be sent
     *
     * @return string
     */
    public function getEndpoint();

}
