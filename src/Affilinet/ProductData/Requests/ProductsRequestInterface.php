<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\AffilinetProductClient;
use Affilinet\ProductData\Responses\ProductsResponseInterface;
use Affilinet\ProductData\Responses\ResponseElements\CategoryInterface;
use Affilinet\ProductData\Responses\ResponseElements\Product;
use Affilinet\ProductData\Responses\ResponseElements\ShopInterface;
use Affilinet\Requests\Helper\QueryInterface;
use Affilinet\Requests\RequestInterface;

/**
 * Interface ProductsRequestInterface
 */
interface ProductsRequestInterface extends \Serializable, RequestInterface
{

    const DEFAULT_FACET_VALUE_LIMIT = 20;

    /**
     * Find one Product by Id
     *
     * @param  integer $productId
     * @return Product
     */
    public function findOne($productId);

    /**
     * @param  array                     $productIds
     * @return ProductsResponseInterface
     */
    public function find(array $productIds);

    /**
     * @return AffilinetProductClient
     */
    public function getAffilinetClient();

    /**
     * Exclude ShopIDs from result
     *
     * Please note the difference between ShopId and ProgramId:
     * each program (= advertiser) has one ProgramId, but might have
     * more than one ShopId, e.g. if the program supplies its
     * electronics products separately from its clothing products.
     * If one of the specified ShopIds is ‘0’, then the search is
     * performed across all shops with which the requesting publisher
     * has an accepted partners
     *
     *
     * @param  array           $shopIDs
     * @return ProductsRequest
     */
    public function excludeShopIds(array $shopIDs);

    /**
     * @param  array           $shopIDs
     * @return ProductsRequest
     */
    public function onlyFromShopIds(array  $shopIDs);

    /**
     * Filter results to these categories only
     *
     * @param  array           $categoryIds
     * @param  bool            $excludeSubCategories
     * @param  bool            $useAffilinetCategories Set to false if you want to use shop internal category IDs
     * @return ProductsRequest
     */
    public function onlyFromCategories(array $categoryIds, $excludeSubCategories = false, $useAffilinetCategories = true);

    /**
     * @param  ShopInterface                       $shop
     * @return $this
     * @throws AffilinetProductWebserviceException
     */
    public function onlyFromShop(ShopInterface $shop);

    /**
     * @param ShopInterface[] array
     * @return $this
     * @throws AffilinetProductWebserviceException
     */
    public function onlyFromShops(array $shops);

    /**
     * @param  CategoryInterface $category
     * @return $this
     */
    public function onlyFromShopCategory(CategoryInterface $category);

    /**
     * @param  CategoryInterface[] $categories
     * @return $this
     */
    public function onlyFromShopCategories(array $categories);

    /**
     * Only results with an image
     *
     * If param $withImageOnly is set to false, all results are included
     *
     * @param  bool            $withImageOnly If set to false, all results will be included
     * @return ProductsRequest
     */
    public function onlyWithImage($withImageOnly = true);

    /**
     * Add the product image in OriginalSize
     * @return ProductsRequest
     */
    public function addProductImage();

    /**
     * Include a product ProductImage with 30px width
     * @return ProductsRequest
     */
    public function addProductImageWithSize30px();

    /**
     * Include a product ProductImage with 60px width
     * @return ProductsRequest
     */
    public function addProductImageWithSize60px();

    /**
     * Include a product ProductImage with 90px width
     * @return ProductsRequest
     */
    public function addProductImageWithSize90px();

    /**
     * Include a product ProductImage with 120px width
     * @return ProductsRequest
     */
    public function addProductImageWithSize120px();

    /**
     * Include a product ProductImage with 180px width
     * @return ProductsRequest
     */
    public function addProductImageWithSize180px();

    /**
     * Include the shop logo with 50px width
     * @return ProductsRequest
     */
    public function addShopLogoWithSize50px();

    /**
     * Include the shop logo with 90px width
     * @return ProductsRequest
     */
    public function addShopLogoWithSize90px();

    /**
     * Include the shop logo with 120px width
     * @return ProductsRequest
     */
    public function addShopLogoWithSize120px();

    /**
     * Include the shop logo with 150px width
     * @return ProductsRequest
     */
    public function addShopLogoWithSize150px();

    /**
     * Include the shop logo with 4680px width
     * @return ProductsRequest
     */
    public function addShopLogoWithSize468px();

    /**
     * Which page to display - starts counting at 1 - defaults to 1
     *
     * If you want to display the first page set $pageNumber to 1
     * @param  int             $pageNumber
     * @return ProductsRequest
     */
    public function page($pageNumber = 1);

    /**
     * Number of products in one page
     * minimum = 1, maximum = 500, default = 10
     *
     * If you want to display the first page set $pageNumber to 1
     * @param  int             $pageNumber minimum = 1, maximum = 500, default = 10
     * @return ProductsRequest
     */
    public function pageSize($pageNumber = 1);

    /**
     * Result sorting. You can only sort by Score (==relevance), price, productName, lastShopUpdate
     *
     * Lets you define along which criteria the search results shall be sorted.
     * Possible values are (case insensitive):
     *
     *   -  Score (a.k.a. rank, relevance)
     *   -  Price (excl. shipping)
     *   -  ProductName
     *   -  LastImported (the date of the last feed update of this product’s shop is considered - not necessarily the last
     *      update of this singe product, but any product of this shop)
     *
     * By default, the results will be sorted by score. Products with the
     * same score will be sorted by LastImported.
     *
     * @param $sortBy (Score, Price, ProductName, LastShopUpdate)
     * @param  bool            $descending
     * @return ProductsRequest
     */
    public function sort($sortBy = 'Score', $descending = true);

    /**
     * Minimum product price
     * @param $price float|int|string If string, no thousand separator and use a point (.) for decimal separator
     * @return ProductsRequest
     */
    public function minPrice($price);

    /**
     * Maximum product price
     *
     * @param $price float|int|string If string, no thousand separator and use a point (.) for decimal separator
     * @return ProductsRequest
     */
    public function maxPrice($price);

    /**
     * Add facet articleNumber
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetArticleNumber($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet brand
     * A maximum of four facets can be added to the result
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetBrand($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet distributor
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetDistributor($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet EAN (European Article Number)
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetEAN($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet manufacturer
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetManufacturer($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet programId
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetProgramId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with shop IDs
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetShopId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with Shop Names
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetShopName($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with Affilinet Category IDs
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetAffilinetCategoryId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with Affilinet Category Path
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetAffilinetCategoryPath($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with Shop Category IDs
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetShopCategoryId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Add facet with Shop Category Paths
     * A maximum of four facets can be added to the result
     *
     * @param  int             $facetValueLimit
     * @return ProductsRequest
     */
    public function addFacetShopCategoryPath($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT);

    /**
     * Serialize this request for use as URI query string
     * @return string
     */
    public function serialize();

    /**
     * Generate ProductsRequest from URI query string
     *
     * @param $serialized string
     * @return ProductsRequest
     */
    public function unserialize($serialized);

    /**
     * @param $query
     * @return ProductsRequest
     */
    public function addRawQuery($query);

    /**
     * @param  QueryInterface            $query
     * @return ProductsRequestInterface;
     */
    public function query(QueryInterface $query);

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addFilterQuery($name, $value);
}
