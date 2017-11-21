<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

use Affilinet\ProductData\Requests\ProductsRequestInterface;

class FacetValue implements FacetValueInterface
{

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $resultCount;

    /**
     * @var FacetInterface
     */
    private $facet;

    /**
     * FacetValue constructor.
     * @param array          $facetValue
     * @param FacetInterface $facet
     */
    public function __construct(array $facetValue, FacetInterface $facet)
    {
        $this->value = $facetValue['FacetValueName'];
        $this->resultCount = $facetValue['FacetValueCount'];
        $this->facet = $facet;

    }

    /**
     * @return string
     */
    public function getDisplayValue()
    {
        switch ($this->getFacet()->getName()) {
            case 'ShopCategoryPathFacet':
            case 'AffilinetCategoryPathFacet':
                $values = explode('^', $this->value);
                if ($values[3] === $values[1]) return $values[1];
                return $values[3];
                break;
        }

        return $this->getValue();
    }

    /**
     * @return FacetInterface
     */
    public function getFacet()
    {
        return $this->facet;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getResultCount()
    {
        return $this->resultCount;
    }

    /**
     * Returns the serialized ProductsRequest to retrieve the results behind this facet value
     * Starting with "?" for usage as URI Query Parameter
     *
     * @param  ProductsRequestInterface $request
     * @return string
     */
    public function generateQueryString(ProductsRequestInterface $request)
    {
        return '?' . $this->generateSerializedProductsRequest($request);
    }

    /**
     * Returns the serialized ProductsRequest to retrieve the results behind this facet value
     *
     * @param  ProductsRequestInterface $request
     * @return string
     */
    public function generateSerializedProductsRequest(ProductsRequestInterface $request)
    {
        $newRequest = clone $request;

        switch ($this->getFacet()->getName()) {
            case 'ShopName':
            case 'ProgramId':
                // There is no valid filter Query for these facets, add debug log

                $request->getAffilinetClient()
                    ->getLog()
                    ->addDebug(
                        'You can not filter SearchProducts with '
                        . $this->getFacet()->getName()
                        . ' Seems like you used this facet and tried to generate a Link or a ProductsRequest for this facets\' results.'
                    );

                break;
            case 'ShopId':

                $newRequest->onlyFromShopIds([$this->getValue()]);
                break;

            case 'ShopCategoryId':
                $newRequest->onlyFromCategories([$this->getValue()], false, false);
                break;

            case 'AffilinetCategoryId':
                $newRequest->onlyFromCategories([$this->getValue()]);
                break;

            default :
                $newRequest->addFilterQuery($this->getFacet()->getName(), $this->getValue());

        }

        return $newRequest->serialize();
    }
}
