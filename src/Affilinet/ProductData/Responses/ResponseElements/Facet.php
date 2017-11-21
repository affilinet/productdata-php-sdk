<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

class Facet implements FacetInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var FacetValue[]
     */
    private $facetValues;

    /**
     * Facet constructor.
     * @param array $facet
     */
    public function __construct(array $facet)
    {
        $this->name = $facet['FacetField'];
        $this->facetValues = [];

        foreach ($facet['FacetValues'] as $facetValue) {
            $this->facetValues[] = new FacetValue($facetValue, $this);
        }

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return FacetValue[]
     */
    public function getValues()
    {
        return $this->facetValues;
    }

}
