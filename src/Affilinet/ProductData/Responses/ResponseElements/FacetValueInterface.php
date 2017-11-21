<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

use Affilinet\ProductData\Requests\ProductsRequestInterface;

interface FacetValueInterface
{
    /**
     * @return string
     */
    public function getValue();

    /**
     * @return string
     */
    public function getDisplayValue();

    /**
     * @return int
     */
    public function getResultCount();

    /**
     * @return FacetInterface
     */
    public function getFacet();

    /**
     * Returns the serialized ProductsRequest to retrieve the results behind this facet value
     *
     * @param  ProductsRequestInterface $request
     * @return string
     */
    public function generateSerializedProductsRequest(ProductsRequestInterface $request);

    /**
     * Returns the serialized ProductsRequest to retrieve the results behind this facet value
     * Starting with "?" for usage as URI Query Parameter
     *
     * @param  ProductsRequestInterface $request
     * @return string
     */
    public function generateQueryString(ProductsRequestInterface $request);
}
