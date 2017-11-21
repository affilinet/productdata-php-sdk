<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class ImageTest
 */
class ImageTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructImage()
    {
        $data = [
            'ImageScale' => 'test',
            'URL' => 'http://www.example.com',
            'Height' => 120,
            'Width' => 60,
        ];
        $image = new \Affilinet\ProductData\Responses\ResponseElements\Image($data);

        $this->assertEquals($data['URL'], $image->getUrl());
        $this->assertEquals($data['ImageScale'], $image->getScaleName());
        $this->assertEquals($data['Height'], $image->getHeight());
        $this->assertEquals($data['Width'], $image->getWidth());
    }

    public function testConstructImageForLogoWorks()
    {
        $data = [
            'LogoScale' => 'test',
            'URL' => 'http://www.example.com',
            'Height' => 120,
            'Width' => 60,
        ];
        $image = new \Affilinet\ProductData\Responses\ResponseElements\Image($data);

        $this->assertEquals($data['URL'], $image->getUrl());
        $this->assertEquals($data['LogoScale'], $image->getScaleName());
        $this->assertEquals($data['Height'], $image->getHeight());
        $this->assertEquals($data['Width'], $image->getWidth());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConstructThrowsIfNoUrl()
    {
        $data = [];
        $image = new \Affilinet\ProductData\Responses\ResponseElements\Image($data);
    }

}
