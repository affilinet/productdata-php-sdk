<?php
/*
 * This file is part of the Affilinet Publisher SDK package.
 *
 * (c) Affilinet GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

use Affilinet\ProductData\Responses\ResponseElements\Facet;
use Affilinet\ProductData\Responses\ResponseElements\Product;
use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class ProductsResponse
 */
class ProductsResponse extends AbstractResponse implements ProductsResponseInterface
{

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var Facet[]
     */
    private $facets;

    /**
     * ProductSearchResponse constructor.
     * @param PsrResponse $response
     */
    public function __construct(PsrResponse $response)
    {
        parent::__construct($response);

        $this->products = [];

        foreach ($this->responseArray['Products'] as $product) {
            $this->products[] = new Product($product);
        }
        $this->facets = [];

        if (isset($this->responseArray['Facets'])) {
            foreach ($this->responseArray['Facets'] as $facet) {
                $this->facets[] = new Facet($facet);
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function totalRecords()
    {
        return $this->responseArray['ProductsSummary']['TotalRecords'];
    }

    /**
     * {@inheritDoc}
     */
    public function pageSize()
    {
        return $this->responseArray['ProductsSummary']['Records'];
    }

    /**
     * {@inheritDoc}
     */
    public function totalPages()
    {
        return $this->responseArray['ProductsSummary']['TotalPages'];
    }

    /**
     * {@inheritDoc}
     */
    public function pageNumber()
    {
        return $this->responseArray['ProductsSummary']['CurrentPage'];
    }

    /**
     * alias of $this->products()
     * @return ResponseElements\Product[]
     */
    public function getProducts()
    {
        return $this->products();
    }

    /**
     * @return ResponseElements\Product[]
     */
    public function products()
    {
        return $this->products;
    }

    /**
     * alias of $this->facets()
     *
     */
    public function getFacets()
    {
        return $this->facets();
    }

    /**
     * @return ResponseElements\Facet[]
     */
    public function facets()
    {
        return $this->facets;
    }

}
