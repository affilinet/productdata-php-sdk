<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class DateParserTest
 */
class DateParserTest extends \PHPUnit_Framework_TestCase
{

    public function testDateParseAcceptsDate()
    {
        date_default_timezone_set("Europe/Berlin");

        $dateString = '/Date(1468928770807+0200)/';
        $dateTime = \Affilinet\ProductData\Responses\DataParser::parseDate($dateString);
        $this->assertEquals('7200', $dateTime->getOffset());
        $this->assertEquals(new DateTimeZone('+02:00'), $dateTime->getTimezone());
        $this->assertEquals('1468921570', $dateTime->getTimestamp());

    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testInvalidStringThrowsUnexpectedValueException()
    {
        $dateString = 'i am not a correct js time object';
        $dateTime = \Affilinet\ProductData\Responses\DataParser::parseDate($dateString);
    }

}
