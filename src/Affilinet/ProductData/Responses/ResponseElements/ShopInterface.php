<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface ShopInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getLastUpdate();

    /**
     * @return Image
     */
    public function getLogo();

    /**
     * @return int
     */
    public function getProductCount();

    /**
     * @return int
     */
    public function getProgramId();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getName();

}
