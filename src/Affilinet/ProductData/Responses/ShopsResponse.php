<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\Shop;
use Affilinet\Responses\AbstractResponse;
use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class ShopsResponse
 */
class ShopsResponse extends AbstractResponse implements ShopsResponseInterface
{
    /**
     * @var Shop[]
     */
    private $shops;

    /**
     * GetProductsResponse constructor.
     * @param PsrResponse $response
     */
    public function __construct(PsrResponse $response)
    {
        parent::__construct($response);

        $this->shops = [];

        foreach ($this->responseArray['Shops'] as $shop) {
            $this->shops[] = new Shop($shop);
        }
    }

    public function totalRecords()
    {
        return $this->responseArray['GetShopListSummary']['TotalRecords'];
    }

    public function pageSize()
    {
        return $this->responseArray['GetShopListSummary']['Records'];
    }

    public function totalPages()
    {
        return $this->responseArray['GetShopListSummary']['TotalPages'];
    }

    public function pageNumber()
    {
        return $this->responseArray['GetShopListSummary']['CurrentPage'];
    }

    /**
     * alias of $this->shops()
     * @return Shop[]
     */
    public function getShops()
    {
        return $this->shops();
    }

    /**
     * @return Shop[]
     */
    public function shops()
    {
        return $this->shops;
    }

}
