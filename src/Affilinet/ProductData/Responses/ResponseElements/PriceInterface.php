<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface PriceInterface
{
    /**
     * Three characters indicating the currency for the product price.
     * Currently, this can be either EUR or GBP.
     *
     * @return string
     */
    public function getCurrency();

    /**
     * This is the ready-to-use string to display the price. E.g.
     * “For a limited time only 15.99 GBP plus shipping”.
     *
     * @return string
     */
    public function getDisplayPrice();

    /**
     * This is the ready-to-use string to display the shipping cost
     * of this item. E.g. “Only 6.99 GBP except for overseas shipping”.
     *
     * @return string|null
     */
    public function getDisplayShipping();

    /**
     * This is the ready-to-use string to display the price of this
     * product calculated on a base measure. E.g. “27.98 GBP per kg”.
     *
     * @return string|null
     */
    public function getDisplayBasePrice();

    /**
     * Former price of this product, as specified by the advertiser.
     *
     * @return float
     */
    public function getPriceOld();

    /**
     * A string to be displayed before the actual price figure (e.g. “From”).
     *
     * @return string
     */
    public function getPricePrefix();

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @return string
     */
    public function getPriceSuffix();

    /**
     * @return string
     */
    public function getShippingPricePrefix();

    /**
     * @return float
     */
    public function getShippingPrice();

    /**
     * @return string
     */
    public function getShippingPriceSuffix();

    /**
     * @return string
     */
    public function getBasePricePrefix();

    /**
     * @return float
     */
    public function getBasePrice();

    /**
     * @return string
     */
    public function getBasePriceSuffix();

}
