<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\Responses\ShopPropertiesResponseInterface;

/**
 * Class ShopPropertiesRequestInterface
 */
interface ShopPropertiesRequestInterface extends RequestInterface
{
    /**
     * @return ShopPropertiesResponseInterface
     * @throws AffilinetProductWebserviceException
     */
    public function send();

    /**
     * @param  integer $shopId
     * @return $this;
     */
    public function setShopId($shopId);

}
