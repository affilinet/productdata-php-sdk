<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses\ResponseElements;

interface ImageInterface
{
    /**
     * @return string
     */
    public function getScaleName();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @return int
     */
    public function getHeight();

}
