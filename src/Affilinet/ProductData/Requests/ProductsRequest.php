<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\Exceptions\AffilinetProductWebserviceException;
use Affilinet\ProductData\Requests\Helper\QueryInterface;
use Affilinet\ProductData\Requests\Traits\ImageTrait;
use Affilinet\ProductData\Requests\Traits\LogoTrait;
use Affilinet\ProductData\Requests\Traits\PaginationTrait;
use Affilinet\ProductData\Responses\ProductsResponse;
use Affilinet\ProductData\Responses\ProductsResponseInterface;
use Affilinet\ProductData\Responses\ResponseElements\CategoryInterface;
use Affilinet\ProductData\Responses\ResponseElements\Product;
use Affilinet\ProductData\Responses\ResponseElements\ShopInterface;
use \GuzzleHttp\Psr7\Request;

/**
 * Search for products
 */
class ProductsRequest extends AbstractRequest implements ProductsRequestInterface
{
    use ImageTrait, LogoTrait, PaginationTrait;

    /**
     * @const string The base URI of the product data webservice.
     */
    const ENDPOINT = 'https://product-api.affili.net/V3/productservice.svc/JSON/SearchProducts';

    const ENDPOINT_ALTERNATE = 'https://product-api.affili.net/V3/productservice.svc/JSON/GetProducts';

    const SORT_BY_RELEVANCE = 'Score';

    const SORT_BY_PRICE = 'Price';

    const SORT_BY_PRODUCT_NAME = 'ProductName';

    const SORT_BY_LAST_PROGRAM_LIST_UPDATE = 'LastImported';

    /**
     * @var boolean $useAlternateEndpoint
     */
    private $useAlternateEndpoint = false;

    /**
     * Find one Product by Id
     *
     * @param  integer      $productId
     * @return Product|null
     */
    public function findOne($productId)
    {
        $this->useAlternateEndpoint = true;
        $this->queryParams['ProductIds'] = $productId;
        $this->addAllProductImages();
        $this->addAllShopLogos();
        $response = $this->send();
        $products = $response->getProducts();
        if (isset($products[0])) {
            return $products[0];
        }

        return null;
    }

    /**
     * @return ProductsResponse
     * @throws AffilinetProductWebserviceException
     */
    public function send()
    {
        // FilterQueries, CategoryIds or Query should be set in request.
        if (
            !isset($this->queryParams['FQ']) &&
            !isset($this->queryParams['CategoryIds']) &&
            !isset($this->queryParams['Query']) &&
            !isset($this->queryParams['ProductIds'])
        ) {
            throw new AffilinetProductWebserviceException('FilterQuery, Category or Query must be set in request.');
        }
        $psr7Request = $this->getPsr7Request();
        $psr7Response = $this->getAffilinetClient()->getHttpClient()->send($psr7Request);
        $searchProductsResponse = new ProductsResponse($psr7Response);

        return $searchProductsResponse;

    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getPsr7Request()
    {
        return new Request('GET', $this->getEndpoint() . '?' . $this->serializeWithCredentials());
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpoint()
    {
        return $this->useAlternateEndpoint ? self::ENDPOINT_ALTERNATE : self::ENDPOINT;
    }

    /**
     * @param  array                     $productIds
     * @return ProductsResponseInterface
     */
    public function find(array $productIds)
    {
        $this->useAlternateEndpoint = true;

        if (count($productIds) > 50) {
            throw new \OverflowException('You can only add up to 50 productIds to one GetProductsRequest');
        }
        $this->queryParams['ProductIds'] = implode(',', $productIds);
        $this->addAllProductImages()
            ->addAllShopLogos();

        return $this->send();
    }

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
     * @param  array                               $shopIDs
     * @return ProductsRequest
     * @throws AffilinetProductWebserviceException
     */
    public function excludeShopIds(array $shopIDs)
    {
        if (isset($this->queryParams['ShopIdMode']) && $this->queryParams['ShopIdMode'] === 'Include') {
            throw  new AffilinetProductWebserviceException('excludeShopIds() can not be combined with onlyFromShopIds() in one ProductsRequest');
        }

        $this->queryParams['ShopIds'] = $this->getShopIdCSV($shopIDs);
        $this->queryParams['ShopIdMode'] = 'Exclude';

        return $this;
    }

    /**
     * @param  array  $shopIDs
     * @return string
     */
    private function getShopIdCSV(array $shopIDs)
    {
        if (empty($shopIDs)) {
            throw new \InvalidArgumentException('Parameter $shopIDs has to be an array and must not be empty');
        }
        foreach ($shopIDs as $key => $id) {
            if (!is_numeric($id) && $id !== 0) {
                throw new \InvalidArgumentException('The value "' . $id . '" is not a valid shopId, shopIds have to be integer. "');
            }
            $shopIDs[$key] = trim($id);
        }

        if (count($shopIDs) > 500) {
            $this->affilinetClient->getLog()->warning('Some shopIds have been ignored: You can include or exclude only a maximum of 500 shops.');
        }

        return implode(',', $shopIDs);
    }

    /**
     * @param  ShopInterface                       $shop
     * @return $this
     * @throws AffilinetProductWebserviceException
     */
    public function onlyFromShop(ShopInterface $shop)
    {
        $this->onlyFromShopIds([$shop->getId()]);

        return $this;
    }

    /**
     * @param  array                               $shopIDs
     * @return ProductsRequest
     * @throws AffilinetProductWebserviceException
     */
    public function onlyFromShopIds(array  $shopIDs)
    {
        if (isset($this->queryParams['ShopIdMode']) && $this->queryParams['ShopIdMode'] === 'Exclude') {
            throw  new AffilinetProductWebserviceException('onlyFromShopIds() can not be combined with excludeShopIds() in one ProductsRequest');
        }
        $this->queryParams['ShopIds'] = $this->getShopIdCSV($shopIDs);
        $this->queryParams['ShopIdMode'] = 'Include';

        return $this;
    }

    /**
     * @param ShopInterface[] array
     * @return $this
     * @throws AffilinetProductWebserviceException
     */
    public function onlyFromShops(array $shops)
    {
        $ids = [];
        foreach ($shops as $shop) {
            $ids[] = $shop->getId();
        }
        $this->onlyFromShopIds($ids);

        return $this;
    }

    /**
     * @param  CategoryInterface $category
     * @return $this
     */
    public function onlyFromShopCategory(CategoryInterface $category)
    {
        $this->onlyFromCategories([$category->getId()], false, false);

        return $this;
    }

    /**
     * @param  array $categoryIds
     * @param  bool  $excludeSubCategories
     * @param  bool  $useAffilinetCategories
     * @return $this
     */
    public function onlyFromCategories(array $categoryIds, $excludeSubCategories = false, $useAffilinetCategories = true)
    {
        $this->queryParams['CategoryIds'] = $this->getCategoryIdCSV($categoryIds);
        $this->queryParams['ExcludeSubCategories'] = ($excludeSubCategories) ? 'true' : 'false';
        $this->queryParams['UseAffilinetCategories'] = ($useAffilinetCategories) ? 'true' : 'false';

        return $this;
    }

    /**
     * @param  array  $categoryIds
     * @return string
     */
    private function getCategoryIdCSV(array  $categoryIds)
    {
        if (empty($categoryIds)) {
            throw new \InvalidArgumentException('$categoryIds has to be an array and must not be empty');
        }
        foreach ($categoryIds as $key => $id) {
            if ($id != intval($id) || intval($id) === 0) {
                throw new \InvalidArgumentException('The value "' . $id . '" is not a valid categoryId, categoryId have to be integer values greater than 0. "');
            }
            $categoryIds[$key] = trim($id);
        }

        if (count($categoryIds) > 100) {
            throw new \OverflowException('Too many categories. You can filter to only a maximum of 100 categoryIds');
        }

        return implode(',', $categoryIds);
    }

    /**
     * @param  CategoryInterface[] $categories
     * @return $this
     */
    public function onlyFromShopCategories(array $categories)
    {
        $ids = [];
        foreach ($categories as $category) {
            $ids[] = $category->getId();
        }
        $this->onlyFromCategories($ids, false, false);

        return $this;
    }

    /**
     * @param  bool  $withImageOnly
     * @return $this
     */
    public function onlyWithImage($withImageOnly = true)
    {
        // always add an image if user requests images
        $this->addProductImage();
        $this->queryParams['WithImageOnly'] = ($withImageOnly) ? 'true' : 'false';

        return $this;
    }

    /**
     * @param  string $sortBy
     * @param  bool   $descending
     * @return $this
     */
    public function sort($sortBy = 'Score', $descending = true)
    {
        switch ($sortBy) {
            case self::SORT_BY_RELEVANCE :
            case self::SORT_BY_PRICE :
            case self::SORT_BY_PRODUCT_NAME :
            case self::SORT_BY_LAST_PROGRAM_LIST_UPDATE :
                break;
            default:
                throw new \InvalidArgumentException('Invalid argument $sortBy with value of "' . $sortBy . '"". Use one of ' .
                    self::SORT_BY_RELEVANCE . ', ' .
                    self::SORT_BY_PRICE . ', ' .
                    self::SORT_BY_PRODUCT_NAME . ' or ' .
                    self::SORT_BY_LAST_PROGRAM_LIST_UPDATE . '! Think about using the class constants in ' . __CLASS__ . '::SORT_BY_(...)');

        }
        $this->queryParams['SortBy'] = $sortBy;
        $this->queryParams['SortOrder'] = ($descending) ? 'descending' : 'ascending';

        return $this;

    }

    /**
     * @param  float|int|string $price
     * @return $this
     */
    public function minPrice($price)
    {
        $this->queryParams['MinimumPrice'] = $this->sanitizePrice($price);

        return $this;
    }

    /**
     * @param $price int|float|string
     * @return string
     */
    private function sanitizePrice($price)
    {
        if (is_float($price)) {
            $floatPrice = $price;
        } elseif (is_int($price)) {
            $floatPrice = (float) $price;
        } elseif (is_string($price)) {
            // string contains
            if (!is_numeric($price) || mb_strpos($price, ',') !== false) {
                throw  new \InvalidArgumentException('Parameter $price must be numeric. Do not use thousand separators. Use a point (.) as decimal separator. Example "10.00"');
            }
            $floatPrice = (float) $price;
        } else {
            throw  new \InvalidArgumentException('Parameter $price must be numeric. Do not use thousand separators. Use a point (.) as decimal separator. Example "10.00"');
        }

        return number_format((float) $floatPrice, 2, '.', '');

    }

    /**
     * @param  float|int|string $price
     * @return $this
     */
    public function maxPrice($price)
    {
        $this->queryParams['MaximumPrice'] = $this->sanitizePrice($price);

        return $this;
    }

    /**
     * @param $facetName
     * @param  int   $facetValueLimit The number of facets entries to be returned
     * @return $this
     */
    private function addFacet($facetName, $facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {

        if (!isset($this->queryParams['FacetFields'])) {
            $facetFields = [];
        } else {
            $facetFields = explode(',', $this->queryParams['FacetFields']);

        }
        if (!in_array($facetName, $facetFields)) {
            $facetFields[] = $facetName;

            if (count($facetFields) > 4) {
                throw new \OverflowException('You can only add up to 4 facets to one ProductsRequest');
            }
            $this->queryParams['FacetFields'] = implode(',', $facetFields);
        }
        $this->queryParams['FacetValueLimit'] = $facetValueLimit;

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetArticleNumber($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('ArticleNumber', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetBrand($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('Brand', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetDistributor($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('Distributor', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetEAN($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('EAN', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetManufacturer($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('Manufacturer', $facetValueLimit);

        return $this;
    }

    /**
     * @deprecated
     *
     * Since there is no valid Filter Query to filter this facets results this  method will be removed
     *
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetProgramId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->getAffilinetClient()->getLog()->addDebug('Method addFacetProgramId is deprecated');
        $this->addFacet('ProgramId', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetShopId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('ShopId', $facetValueLimit);

        return $this;
    }

    /**
     * @deprecated
     *
     * Since there is no valid Filter Query to filter this facets results this  method will be removed
     *
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetShopName($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->getAffilinetClient()->getLog()->addDebug('Method addFacetShopName is deprecated');
        $this->addFacet('ShopName', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetAffilinetCategoryId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('AffilinetCategoryId', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetAffilinetCategoryPath($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('AffilinetCategoryPathFacet', $facetValueLimit);

        return $this;
    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetShopCategoryId($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('ShopCategoryId', $facetValueLimit);

        return $this;

    }

    /**
     * @param  int   $facetValueLimit
     * @return $this
     */
    public function addFacetShopCategoryPath($facetValueLimit = self::DEFAULT_FACET_VALUE_LIMIT)
    {
        $this->addFacet('ShopCategoryPathFacet', $facetValueLimit);

        return $this;
    }

    /**
     * @param $query
     * @return $this
     */
    public function addRawQuery($query)
    {
        $this->queryParams['Query'] = $query;

        return $this;
    }

    /**
     * @param  QueryInterface            $query
     * @return ProductsRequestInterface;
     */
    public function query(QueryInterface $query)
    {
        $this->queryParams['Query'] = $query->getQuery() ;

        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addFilterQuery($name, $value)
    {
        //=field1:value1,field2:value2,field3:value3
        if (!isset($this->queryParams['FQ'])) {
            $this->queryParams['FQ'] = $name . ':' . $value;
        } else {
            // has this FilterQuery already been added?
            $existingFilterQuery = explode(',', $this->queryParams['FQ']);
            foreach ($existingFilterQuery as $oneFilterQuery) {
                $oneFilterQueryArray = explode(':', $oneFilterQuery);
                if ($oneFilterQueryArray[0] === $name) {
                    $this->affilinetClient->getLog()->addWarning('You tried to add the FilterQuery' . $name .' twice. The value "' . $value . '" has been ignored.');

                    return $this;
                }
            }
            $this->queryParams['FQ'] .= ',' . $name . ':' . $value;
        }

        return $this;
    }

}
