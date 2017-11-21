<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

use Affilinet\ProductData\Responses\DataParser;

class Shop implements ShopInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \DateTime $lastUpdate
     */
    private $lastUpdate;

    /**
     * @var Image[] $logo
     */
    private $logo;

    /**
     * @var integer $productCount
     */
    private $productCount;

    /**
     * @var integer $programId
     */
    private $programId;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var string $name
     */
    private $name;

    /**
     * Shop constructor.
     * @param array $shop
     */
    public function __construct(array $shop)
    {
        $this->id = $shop['ShopId'];
        $this->lastUpdate = DataParser::parseDate($shop['LastUpdate']);
        $this->productCount = intval($shop['ProductCount']);
        $this->programId = intval($shop['ProgramId']);
        $this->url = $shop['ShopLink'];
        $this->name = $shop['ShopTitle'];
        if (isset($shop['Logo'])) {
            $this->logo = new Image($shop['Logo']);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @return ImageInterface[]
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return int
     */
    public function getProductCount()
    {
        return $this->productCount;
    }

    /**
     * @return int
     */
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
