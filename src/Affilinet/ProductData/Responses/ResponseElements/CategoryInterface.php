<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface CategoryInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getIdPath();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getNamePath();

    /**
     * @return integer
     */
    public function getProductCount();

}
