<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

class  Category implements CategoryInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $idPath
     */
    private $idPath;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $namePath
     */
    private $namePath;

    /**
     * @var integer $productCount
     */
    private $productCount;

    public function __construct($category)
    {
        $this->id = $category['Id'];
        $this->idPath = $category['IdPath'];
        $this->name = $category['Title'];
        $this->namePath = $category['TitlePath'];
        $this->productCount = $category['ProductCount'];
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdPath()
    {
        return $this->idPath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNamePath()
    {
        return $this->namePath;
    }

    /**
     * @return integer
     */
    public function getProductCount()
    {
        return $this->productCount;
    }

}
