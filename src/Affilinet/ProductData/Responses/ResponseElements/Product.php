<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

use Affilinet\Responses\DataParser;

class Product implements ProductInterface
{
    use DataParser;

    /**
     * @var string
     */
    private $articleNumber;

    /**
     * @var \DateTime
     */
    private $lastShopUpdate;

    /**
     * @var \DateTime
     */
    private $lastProductChange;

    /**
     * @var float
     */
    private $score;

    /**
     * @var integer
     */
    private $productId;

    /**
     * @var integer
     */
    private $shopId;

    /**
     * @var string
     */
    private $shopTitle;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $descriptionShort;

    /**
     * @var integer
     */
    private $shopCategoryId;

    /**
     * @var integer
     */
    private $affilinetCategoryId;

    /**
     * @var string
     */
    private $shopCategoryPath;

    /**
     * @var string
     */
    private $affilinetCategoryPath;

    /**
     * @var string
     */
    private $shopCategoryIdPath;

    /**
     * @var string
     */
    private $affilinetCategoryIdPath;

    /**
     * @var string
     */
    private $deeplink1;

    /**
     * @var string
     */
    private $deeplink2;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $distributor;

    /**
     * @var string
     */
    private $EAN;

    /**
     * @var string
     */
    private $keywords;

    /**
     * @var PriceInterface
     */
    private $priceInformation;

    /**
     * @var ImageInterface[]
     */
    private $images;

    /**
     * @var ImageInterface[]
     */
    private $logos;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var integer
     */
    private $programId;

    /**
     * Product constructor.
     * @param array $properties
     */
    public function __construct(array $properties)
    {
        $this->articleNumber = $properties['ArticleNumber'];
        $this->lastShopUpdate = $this->parseDate($properties['LastShopUpdate']);
        $this->lastProductChange = $this->parseDate($properties['LastProductChange']);
        if (isset($properties['Score'])) {
            $this->score = $properties['Score'];
        }

        $this->productId = $properties['ProductId'];
        $this->shopId = $properties['ShopId'];
        $this->shopTitle = $properties['ShopTitle'];
        $this->productName = $properties['ProductName'];
        $this->description = $properties['Description'];
        $this->descriptionShort = $properties['DescriptionShort'];
        $this->shopCategoryId = $properties['ShopCategoryId'];
        $this->affilinetCategoryId = $properties['AffilinetCategoryId'];
        $this->shopCategoryPath = $properties['ShopCategoryPath'];
        $this->affilinetCategoryPath = $properties['AffilinetCategoryPath'];
        $this->shopCategoryIdPath = $properties['ShopCategoryIdPath'];
        $this->affilinetCategoryIdPath = $properties['AffilinetCategoryIdPath'];
        $this->deeplink1 = $properties['Deeplink1'];

        if (isset($properties['Deeplink2']) && $properties['Deeplink2'] !== '') {
            $this->deeplink2 = $properties['Deeplink2'];
        } else {
            $this->deeplink2 = null;
        }

        $this->brand = $properties['Brand'];
        $this->manufacturer = $properties['Manufacturer'];
        $this->distributor = $properties['Distributor'];
        $this->EAN = $properties['EAN'];
        $this->keywords = $properties['Keywords'];

        $this->priceInformation = new Price($properties['PriceInformation']);
        $this->programId = $properties['ProgramId'];

        $this->images = [];
        if (isset($properties['Images']) && $properties['Images'] !== []) {

            if (isset($properties['Images'][0]['ImageScale'])) {

                foreach ($properties['Images'] as $image) {
                    $this->images[] = new Image($image);
                }
            } else {
                foreach ($properties['Images'][0] as $image) {
                    $this->images[] = new Image($image);
                }
            }

        }

        $this->logos = [];
        if (isset($properties['Logos']) && $properties['Logos'] !== []) {

            if (isset($properties['Logos'][0]['LogoScale'])) {

                foreach ($properties['Logos'] as $image) {
                    $this->logos[] = new Image($image);
                }

            } else {

                foreach ($properties['Logos'][0] as $image) {
                    $this->logos[] = new Image($image);
                }

            }

        }

        $this->properties = [];

        if (isset($properties['Properties'])) {

            foreach ($properties['Properties'] as $property) {
                $this->properties[$property['PropertyName']] = $property['PropertyValue'];
            }
        }
    }

    /**
     * @return string
     */
    public function getArticleNumber()
    {
        return $this->articleNumber;
    }

    /**
     * @return \DateTime
     */
    public function getLastShopUpdate()
    {
        return $this->lastShopUpdate;
    }

    /**
     * @return \DateTime
     */
    public function getLastProductChange()
    {
        return $this->lastProductChange;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return integer
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @return string
     */
    public function getShopTitle()
    {
        return $this->shopTitle;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDescriptionShort()
    {
        return $this->descriptionShort;
    }

    /**
     * @return integer
     */
    public function getShopCategoryId()
    {
        return $this->shopCategoryId;
    }

    /**
     * @return integer
     */
    public function getAffilinetCategoryId()
    {
        return $this->affilinetCategoryId;
    }

    /**
     * @return string
     */
    public function getShopCategoryPath()
    {
        return $this->shopCategoryPath;
    }

    /**
     * @return string
     */
    public function getAffilinetCategoryPath()
    {
        return $this->affilinetCategoryPath;
    }

    /**
     * @return string
     */
    public function getShopCategoryIdPath()
    {
        return $this->shopCategoryIdPath;
    }

    /**
     * @return string
     */
    public function getAffilinetCategoryIdPath()
    {
        return $this->affilinetCategoryIdPath;
    }

    /**
     * @return string
     */
    public function getDeeplink()
    {
        return $this->deeplink1;
    }

    /**
     * @param $useDeeplinkAsFallback
     * @return string|null
     */
    public function getAlternativeDeeplink($useDeeplinkAsFallback = false)
    {
        if ($this->hasAlternativeDeeplink()) {
            return $this->deeplink2;
        }
        if ($useDeeplinkAsFallback === true) {
            return $this->deeplink1;
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasAlternativeDeeplink()
    {
        return isset($this->deeplink2);
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @return string
     */
    public function getDistributor()
    {
        return $this->distributor;
    }

    /**
     * @return string
     */
    public function getEAN()
    {
        return $this->EAN;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @return PriceInterface
     */
    public function getPriceInformation()
    {
        return $this->priceInformation;
    }

    /**
     * @return ImageInterface[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return ImageInterface[]
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param  $propertyName string
     * @return string
     */
    public function getProperty($propertyName)
    {
        if ($this->hasProperty($propertyName))
            return $this->properties[$propertyName];

        return null;
    }

    /**
     * @param  $propertyName string
     * @return bool
     */
    public function hasProperty($propertyName)
    {
        return isset($this->properties[$propertyName]);
    }

    /**
     * @return integer
     */
    public function getProgramId()
    {
        return $this->programId;
    }

}
