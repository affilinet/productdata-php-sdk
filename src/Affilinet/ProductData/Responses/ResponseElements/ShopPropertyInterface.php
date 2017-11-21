<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface ShopPropertyInterface
{

    /**
     * @return string
     */
    public function getPropertyName();

    /**
     * @return \DateTime
     */
    public function getTotalCount();

}
