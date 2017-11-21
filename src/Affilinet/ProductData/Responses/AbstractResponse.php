<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class AbstractResponse
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * @var ResponseInterface $response
     */
    protected $response;

    /**
     * @var array $responseArray
     */
    protected $responseArray;

    /**
     * @var string $responseBody
     */
    protected $responseBody;
    protected $responseString;

    protected function __construct(PsrResponse $response)
    {
        $this->response = $response;
        $body = $this->response->getBody()->getContents();

        $bom = pack("CCC", 0xef, 0xbb, 0xbf);
        if (0 === strncmp($body, $bom, 3)) {
            $body = substr($body, 3);
        }
        $this->responseString = $body;
        $this->responseArray = json_decode($this->getResponseString(), true);

        // writes $this->responseArray;
        $this->jsonSerialize();

    }

    /**
     * @return string
     */
    public function getResponseString()
    {
        return $this->responseString;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->responseArray;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->jsonSerialize();
    }

}
