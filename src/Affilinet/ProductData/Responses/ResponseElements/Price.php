<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

class Price implements PriceInterface
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $displayPrice;

    /**
     * @var string
     */
    private $displayShipping;

    /**
     * @var string
     */
    private $displayBasePrice;

    /**
     * @var float
     */
    private $priceOld;

    /**
     * @var string
     */
    private $pricePrefix;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $priceSuffix;

    /**
     * @var string
     */
    private $shippingPricePrefix;

    /**
     * @var float
     */
    private $shippingPrice;

    /**
     * @var string
     */
    private $shippingPriceSuffix;

    /**
     * @var string
     */
    private $basePricePrefix;

    /**
     * @var float
     */
    private $basePrice;

    /**
     * @var string
     */
    private $basePriceSuffix;

    public function __construct(array $priceArray)
    {

        if (!isset($priceArray['Currency']) || !isset($priceArray['DisplayPrice']) || !isset($priceArray['PriceDetails']) || $priceArray['PriceDetails'] === []) {
            throw new \UnexpectedValueException('DisplayPrice or Currency or PriceDetails is missing for Product.');
        }
        $this->currency = $priceArray['Currency'];
        $this->displayPrice = $priceArray['DisplayPrice'];

        if (isset($priceArray['DisplayShipping'])) {
            $this->displayShipping = $priceArray['DisplayShipping'];
        }

        if (isset($priceArray['DisplayBasePrice'])) {
            $this->displayBasePrice = $priceArray['DisplayBasePrice'];
        }

        $this->priceOld = $priceArray['PriceDetails']['PriceOld'];
        $this->pricePrefix = $priceArray['PriceDetails']['PricePrefix'];
        $this->price = $priceArray['PriceDetails']['Price'];
        $this->priceSuffix = $priceArray['PriceDetails']['PriceSuffix'];

        if (isset($priceArray['ShippingDetails'])) {
            $this->shippingPricePrefix = $priceArray['ShippingDetails']['ShippingPrefix'];
            $this->shippingPrice = $priceArray['ShippingDetails']['Shipping'];
            $this->shippingPriceSuffix = $priceArray['ShippingDetails']['ShippingSuffix'];
        }

        if (isset($priceArray['BasePriceDetails'])) {
            $this->basePricePrefix = $priceArray['BasePriceDetails']['BasePricePrefix'];
            $this->basePrice = $priceArray['BasePriceDetails']['BasePrice'];
            $this->basePriceSuffix = $priceArray['BasePriceDetails']['BasePriceSuffix'];
        }

    }

    /**
     * Three characters indicating the currency for the product price.
     * Currently, this can be either EUR or GBP.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * This is the ready-to-use string to display the price. E.g.
     * “For a limited time only 15.99 GBP plus shipping”.
     *
     * @return string
     */
    public function getDisplayPrice()
    {
        return $this->displayPrice;
    }

    /**
     * This is the ready-to-use string to display the shipping cost
     * of this item. E.g. “Only 6.99 GBP except for overseas shipping”.
     *
     * @return string|null
     */
    public function getDisplayShipping()
    {
        return $this->displayShipping;
    }

    /**
     * This is the ready-to-use string to display the price of this
     * product calculated on a base measure. E.g. “27.98 GBP per kg”.
     *
     * @return string|null
     */
    public function getDisplayBasePrice()
    {
        return $this->displayBasePrice;
    }

    /**
     * Former price of this product, as specified by the advertiser.
     *
     * @return float
     */
    public function getPriceOld()
    {
        return $this->priceOld;
    }

    /**
     * A string to be displayed before the actual price figure (e.g. “From”).
     *
     * @return string
     */
    public function getPricePrefix()
    {
        return $this->pricePrefix;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPriceSuffix()
    {
        return $this->priceSuffix;
    }

    /**
     * @return string
     */
    public function getShippingPricePrefix()
    {
        return $this->shippingPricePrefix;
    }

    /**
     * @return float
     */
    public function getShippingPrice()
    {
        return $this->shippingPrice;
    }

    /**
     * @return string
     */
    public function getShippingPriceSuffix()
    {
        return $this->shippingPriceSuffix;
    }

    /**
     * @return string
     */
    public function getBasePricePrefix()
    {
        return $this->basePricePrefix;
    }

    /**
     * @return float
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @return string
     */
    public function getBasePriceSuffix()
    {
        return $this->basePriceSuffix;
    }

}
