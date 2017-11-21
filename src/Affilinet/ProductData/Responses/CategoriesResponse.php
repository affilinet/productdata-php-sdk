<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\Category;
use Affilinet\ProductData\Responses\ResponseElements\CategoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CategoriesResponse
 * @package Affilinet\ProductData\Responses
 */
class CategoriesResponse extends AbstractResponse implements CategoriesResponseInterface
{
    /**
     * @var CategoryInterface[]
     */
    private $categories;

    /**
     * GetProductsResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->categories = [];

        foreach ($this->responseArray['Categories'] as $shop) {
            $this->categories[] = new Category($shop);
        }
    }

    /**
     * @return int
     */
    public function totalRecords()
    {
        return $this->responseArray['GetCategoryListSummary']['TotalRecords'];
    }

    /**
     * @return int
     */
    public function pageSize()
    {
        return $this->responseArray['GetCategoryListSummary']['Records'];
    }

    /**
     * @return int
     */
    public function totalPages()
    {
        return $this->responseArray['GetCategoryListSummary']['TotalPages'];
    }

    /**
     * @return int
     */
    public function pageNumber()
    {
        return $this->responseArray['GetCategoryListSummary']['CurrentPage'];
    }

    /**
     * @return int
     */
    public function getProgramId()
    {
        return intval($this->responseArray['GetCategoryListSummary']['ProgramId']);
    }

    /**
     * @return string
     */
    public function getProgramName()
    {
        return $this->responseArray['GetCategoryListSummary']['ProgramTitle'];
    }

    /**
     * @return integer
     */
    public function getShopId()
    {
        return intval($this->responseArray['GetCategoryListSummary']['ShopId']);
    }

    /**
     * @return string
     */
    public function getShopName()
    {
        return $this->responseArray['GetCategoryListSummary']['ShopTitle'];
    }

    /**
     * alias of $this->categories()
     * @return CategoryInterface[]
     */
    public function getCategories()
    {
        return $this->categories();
    }

    /**
     * @return CategoryInterface[]
     */
    public function categories()
    {
        return $this->categories;
    }

}
