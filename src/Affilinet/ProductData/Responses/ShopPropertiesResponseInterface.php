<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;
use Affilinet\ProductData\Responses\ResponseElements\ShopPropertyInterface;
use Affilinet\Responses\ResponseInterface;

/**
 * Interface ShopPropertiesResponseInterface
 */
interface ShopPropertiesResponseInterface extends ResponseInterface
{
    /**
     * Number of total Properties for this shop
     * @return int
     */
    public function totalProperties();

    /**
     * alias for totalProperties()
     *
     * @return int
     */
    public function totalRecords();

    /**
     * Id  ot the shop, these properties belong to
     * @return integer
     */
    public function getShopId();

    /**
     * Property exists?
     *
     * @param $propertyName
     * @return bool
     */
    public function hasProperty($propertyName);

    /**
     * @param $propertyName
     * @return ShopPropertyInterface
     */
    public function getProperty($propertyName);

    /**
     * @return ShopPropertyInterface[]
     */
    public function getProperties();

}
