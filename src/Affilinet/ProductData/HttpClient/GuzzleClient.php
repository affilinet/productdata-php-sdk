<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\HttpClient;

use Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Send API Requests with guzzle
 */
class GuzzleClient implements HttpClientInterface
{

    /**
     * @var ClientInterface
     */
    private $guzzle;

    /**
     * GuzzleClient constructor.
     * @param ClientInterface $guzzle
     */
    public function __construct(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param  $request     RequestInterface
     * @param  $options     array
     *
     * @throws AffilinetProductWebserviceException
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        $options = array_merge($options, ['http_errors' => false]);

        $psr7Response = $this->guzzle->send($request, $options);

        if ($psr7Response->getStatusCode() === 400) {
            $responseArray = \GuzzleHttp\json_decode($psr7Response->getBody(), true);
            throw new AffilinetProductWebserviceException($responseArray['ErrorMessages'][0]['Value']);
        }

        return $psr7Response;
    }

}
