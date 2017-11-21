<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

class ShopProperty implements ShopPropertyInterface
{

    /**
     * @var string $propertyName
     */
    private $propertyName;

    /**
     * @var integer $totalCount
     */
    private $totalCount;

    /**
     * ShopProperty constructor.
     * @param $propertyName string
     * @param $totalCount int
     */
    public function __construct($propertyName, $totalCount)
    {
        $this->propertyName = $propertyName;
        $this->totalCount = $totalCount;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @return integer
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

}
