<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface ProductInterface
{
    /**
     * @return string
     */
    public function getArticleNumber();

    /**
     * @return \DateTime
     */
    public function getLastShopUpdate();

    /**
     * @return \DateTime
     */
    public function getLastProductChange();

    /**
     * @return float
     */
    public function getScore();

    /**
     * @return integer
     */
    public function getProductId();

    /**
     * @return integer
     */
    public function getShopId();

    /**
     * @return string
     */
    public function getShopTitle();

    /**
     * @return string
     */
    public function getProductName();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getDescriptionShort();

    /**
     * @return integer
     */
    public function getShopCategoryId();

    /**
     * @return integer
     */
    public function getAffilinetCategoryId();

    /**
     * @return string
     */
    public function getShopCategoryPath();

    /**
     * @return string
     */
    public function getAffilinetCategoryPath();

    /**
     * @return string
     */
    public function getShopCategoryIdPath();

    /**
     * @return string
     */
    public function getAffilinetCategoryIdPath();

    /**
     * @return string
     */
    public function getDeeplink();

    /**
     * @return boolean
     */
    public function hasAlternativeDeeplink();

    /**
     * @param $useDeeplinkAsFallback
     * @return mixed
     */
    public function getAlternativeDeeplink($useDeeplinkAsFallback = false);

    /**
     * @return string
     */
    public function getBrand();

    /**
     * @return string
     */
    public function getManufacturer();

    /**
     * @return string
     */
    public function getDistributor();

    /**
     * @return string
     */
    public function getEAN();

    /**
     * @return string
     */
    public function getKeywords();

    /**
     * @return Price
     */
    public function getPriceInformation();

    /**
     * @return Image[]
     */
    public function getImages();

    /**
     * @return Image[]
     */
    public function getLogos();

    /**
     * @return array
     */
    public function getProperties();

    /**
     * @param $propertyName string
     * @return bool
     */
    public function hasProperty($propertyName);

    /**
     * @param $propertyName string
     * @return string
     */
    public function getProperty($propertyName);

    /**
     * @return integer
     */
    public function getProgramId();

}
