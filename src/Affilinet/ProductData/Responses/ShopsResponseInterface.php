<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\Shop;

/**
 * {@inheritDoc}
 */
interface ShopsResponseInterface extends ResponseInterface
{
    public function totalRecords();

    public function pageSize();

    public function totalPages();

    public function pageNumber();

    /**
     * @return Shop[]
     */
    public function shops();

    /**
     * alias of $this->shops()
     * @return Shop[]
     */
    public function getShops();

}
