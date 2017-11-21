<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

class Image implements ImageInterface
{

    /**
     * @var string
     */
    private $scaleName;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * Image constructor.
     * @param array $image
     */
    public function __construct(array $image)
    {

        if (!isset($image['URL'])) {
            throw new \UnexpectedValueException('URL is missing for Image.');
        }

        if (isset($image['ImageScale'])) {
            $this->scaleName = $image['ImageScale'];
        } elseif (isset($image['LogoScale'])) {
            $this->scaleName = $image['LogoScale'];
        }
        $this->url = $image['URL'];
        $this->width = $image['Width'];
        $this->height = $image['Height'];
    }

    /**
     * @return string
     */
    public function getScaleName()
    {
        return $this->scaleName;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

}
