<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface FacetInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return FacetValue[]
     */
    public function getValues();
}
