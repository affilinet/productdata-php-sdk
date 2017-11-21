<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\Requests\Traits\ShopLogoTrait;
use Affilinet\ProductData\Requests\Traits\PaginationTrait;
use Affilinet\ProductData\Responses\ShopsResponse;
use Affilinet\ProductData\Responses\ShopsResponseInterface;

/**
 * Class ShopsRequest
 */
class ShopsRequest extends AbstractRequest implements ShopsRequestInterface
{
    use ShopLogoTrait, PaginationTrait;

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'https://product-api.affili.net/V3/productservice.svc/JSON/GetShopList';
    }

    /**
     * @return ShopsResponseInterface
     * @throws AffilinetProductWebserviceException
     */
    public function send()
    {
        $psr7Request = $this->getPsr7Request();
        $psr7Response = $this->getAffilinetClient()->getHttpClient()->send($psr7Request);
        $response = new ShopsResponse($psr7Response);

        return $response;

    }

    /**
     * @param  \DateTime $date
     * @return $this;
     */
    public function onlyShopsUpdatedAfter(\DateTime $date)
    {
        $this->queryParams['UpdatedAfter'] = $date->format('c');

        return $this;
    }

    /**
     * @param  string $keyword
     * @return $this;
     */
    public function onlyShopsMatchingKeyword($keyword)
    {
        if (!is_scalar($keyword)) throw new \InvalidArgumentException('Parameter $keyword should be a string and must be scalar');
        $this->queryParams['Query'] = $keyword;

        return $this;
    }

}
