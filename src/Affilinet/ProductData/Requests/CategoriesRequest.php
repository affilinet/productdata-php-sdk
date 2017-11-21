<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\AffilinetClient;
use Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\Requests\Traits\PaginationTrait;
use Affilinet\ProductData\Responses\CategoriesResponse;
use Affilinet\ProductData\Responses\CategoriesResponseInterface;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

/**
 * Class CategoriesRequest
 * @package Affilinet\Publisher\Requests
 */
class CategoriesRequest extends AbstractRequest implements CategoriesRequestInterface
{
    use PaginationTrait;

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return 'https://product-api.affili.net/V3/productservice.svc/JSON/GetCategoryList';
    }

    /**
     * CategoriesRequest constructor.
     * @param AffilinetClient $affilinetClient
     */
    public function __construct(AffilinetClient $affilinetClient)
    {
        parent::__construct($affilinetClient);
        $this->queryParams['ShopId'] = 0;
    }

    /**
     * @return CategoriesResponseInterface
     * @throws AffilinetProductWebserviceException
     */
    public function send()
    {
        $psr7Request = $this->getPsr7Request();
        $psr7Response = $this->getAffilinetClient()->getHttpClient()->send($psr7Request);
        $response = new CategoriesResponse($psr7Response);

        return $response;

    }

    /**
     * @param  integer $shopId
     * @return $this;
     */
    public function setShopId($shopId = 0)
    {
        if (!is_integer($shopId) && $shopId !== 0) {
            throw new InvalidArgumentException('$shopId must be an integer value or 0');
        }
        $this->queryParams['ShopId'] = $shopId;

        return $this;
    }

    /**
     * @return $this
     */
    public function getAffilinetCategories()
    {
        $this->queryParams['ShopId'] = 0;

        return $this;
    }

}
