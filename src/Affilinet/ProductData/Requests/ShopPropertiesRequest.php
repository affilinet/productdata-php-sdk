<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\Responses\ShopPropertiesResponse;
use Affilinet\ProductData\Responses\ShopPropertiesResponseInterface;
use Affilinet\Requests\AbstractRequest;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class ShopPropertiesRequest
 */
class ShopPropertiesRequest extends AbstractRequest implements ShopPropertiesRequestInterface
{

    /**
     * @const string The base URI of the product data webservice.
     */

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'https://product-api.affili.net/V3/productservice.svc/JSON/GetPropertyList';
    }

    /**
     * @return ShopPropertiesResponseInterface
     * @throws AffilinetProductWebserviceException
     */
    public function send()
    {
        $psr7Request = $this->getPsr7Request();
        $psr7Response = $this->getAffilinetClient()->getHttpClient()->send($psr7Request);
        $response = new ShopPropertiesResponse($psr7Response);

        return $response;

    }

    /**
     * @param  integer $shopId
     * @return $this;
     */
    public function setShopId($shopId)
    {
        if (!is_integer($shopId)) {
            throw new InvalidArgumentException('$shopId must be an integer value');
        }
        $this->queryParams['ShopId'] = $shopId;

        return $this;
    }

}
