<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests\Traits;

trait ImageTrait
{
    /**
     * @return $this
     */
    public function addProductImage()
    {
        $this->addImageScale('OriginalImage');

        return $this;
    }

    /**
     * @return $this
     */
    public function addAllProductImages()
    {
        $this
            ->addProductImageWithSize30px()
            ->addProductImageWithSize60px()
            ->addProductImageWithSize90px()
            ->addProductImageWithSize120px()
            ->addProductImageWithSize180px()
            ->addImageScale('OriginalImage');

        return $this;
    }
    /**
     * @param $scale
     * @return $this
     */
    private function addImageScale($scale)
    {
        if (!isset($this->queryParams['ImageScales'])) {
            $scales = [];
        } else {
            $scales = explode(',', $this->queryParams['ImageScales']);
        }
        if (!in_array($scale, $scales)) {
            $scales[] = $scale;
        }
        $this->queryParams['ImageScales'] = implode(',', $scales);

        return $this;
    }

    /**
     * @return $this
     */
    public function addProductImageWithSize30px()
    {
        $this->addImageScale('Image30');

        return $this;
    }

    /**
     * @return $this
     */
    public function addProductImageWithSize60px()
    {
        $this->addImageScale('Image60');

        return $this;
    }

    /**
     * @return $this
     */
    public function addProductImageWithSize90px()
    {
        $this->addImageScale('Image90');

        return $this;
    }

    /**
     * @return $this
     */
    public function addProductImageWithSize120px()
    {
        $this->addImageScale('Image120');

        return $this;
    }

    /**
     * @return $this
     */
    public function addProductImageWithSize180px()
    {
        $this->addImageScale('Image180');

        return $this;

    }

}
