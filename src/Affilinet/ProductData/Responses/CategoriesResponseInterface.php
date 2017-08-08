<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\CategoryInterface;
use Affilinet\Responses\ResponseInterface;

/**
 * Class CategoriesResponseInterface
 */
interface CategoriesResponseInterface extends ResponseInterface
{

    /**
     * @return int
     */
    public function totalRecords();

    /**
     * @return int
     */
    public function pageSize();

    /**
     * @return int
     */
    public function totalPages();

    /**
     * @return int
     */
    public function pageNumber();

    /**
     * @return int
     */
    public function getProgramId();

    /**
     * @return string
     */
    public function getProgramName();

    /**
     * @return integer
     */
    public function getShopId();

    /**
     * @return string
     */
    public function getShopName();

    /**
     * @return CategoryInterface[]
     */
    public function categories();

    /**
     * alias of $this->categories()
     * @return CategoryInterface[]
     */
    public function getCategories();

}
