<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Responses;

trait DataParser
{

    private static $datePattern = '/^\/Date\((\d{10})(\d{3})([+-]\d{4})\)\/$/';
    private static $dateFormat = 'U.u.O';
    private static $dateMask = '%2$s.%3$s.%4$s';

    /**
     * @param $string string
     *
     * @return \DateTime
     */
    public static function parseDate($string)
    {
        $string = (string) $string;

        $r = preg_match('/^\/Date\((\d{10})(\d{3})([+-]\d{4})\)\/$/', $string, $matches);
        if (!$r) {
            throw new \UnexpectedValueException('Preg Regex Pattern failed.');
        }
        $buffer = vsprintf(self::$dateMask, $matches);
        $result = \DateTime::createFromFormat(self::$dateFormat, $buffer);

        return $result;
    }

}
