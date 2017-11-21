<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;
use Affilinet\ProductData\Responses\ResponseElements\ShopProperty;
use Affilinet\ProductData\Responses\ResponseElements\ShopPropertyInterface;
use Psr\Http\Message\ResponseInterface as PsrResponse;

/**
 * Class ShopPropertiesResponse
 */
class ShopPropertiesResponse extends AbstractResponse implements ShopPropertiesResponseInterface
{
    /**
     * @var ShopPropertyInterface[]
     */
    private $properties;

    /**
     * GetProductsResponse constructor.
     * @param PsrResponse $response
     */
    public function __construct(PsrResponse $response)
    {
        parent::__construct($response);

        $this->properties = [];

        foreach ($this->responseArray['PropertyCounts'] as $property) {
            $this->properties[$property['PropertyName']] = new ShopProperty($property['PropertyName'], intval($property['TotalCount']));
        }
    }

    /**
     * alias for totalProperties()
     *
     * @return int
     */
    public function totalRecords()
    {
        return $this->totalProperties();
    }

    /**
     * Number of total Properties for this shop
     * @return int
     */
    public function totalProperties()
    {
        return intval(count($this->responseArray['PropertyCounts']));
    }

    /**
     * ShopId these properties belong to
     * @return integer
     */
    public function getShopId()
    {
        return $this->responseArray['GetPropertyListSummary']['ShopId'];
    }

    /**
     * @param $propertyName
     * @return ShopPropertyInterface
     */
    public function getProperty($propertyName)
    {
        if ($this->hasProperty($propertyName))
            return $this->properties[$propertyName];
        return null;
    }

    /**
     * Property exists?
     *
     * @param $propertyName
     * @return bool
     */
    public function hasProperty($propertyName)
    {
        return key_exists($propertyName, $this->properties);
    }

    /**
     * @return ShopPropertyInterface[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

}
