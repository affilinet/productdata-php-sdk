<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\Facet;
use Affilinet\ProductData\Responses\ResponseElements\Product;

/**
 * Interface ProductsResponseInterface
 */
interface ProductsResponseInterface extends ResponseInterface
{
    /**
     * @return integer
     */
    public function totalRecords();

    /**
     * @return integer
     */
    public function pageSize();

    /**
     * @return integer
     */
    public function totalPages();

    /**
     * @return integer
     */
    public function pageNumber();

    /**
     * @return Product[]
     */
    public function products();

    /**
     * @return Facet[]|null
     */
    public function facets();

}
