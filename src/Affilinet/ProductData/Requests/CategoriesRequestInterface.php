<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\Responses\CategoriesResponseInterface;

/**
 *  Get the categories of a shop
 */
interface CategoriesRequestInterface extends RequestInterface
{
    /**
     * @return CategoriesResponseInterface
     */
    public function send();

    /**
     * @param $shopId
     * @return $this
     */
    public function setShopId($shopId);

    /**
     * @return $this
     */
    public function getAffilinetCategories();

}
