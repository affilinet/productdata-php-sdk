<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\Responses;

/**
 * Interface ResponseInterface
 */
interface ResponseInterface extends \JsonSerializable
{

    public function getResponseString();

    public function toArray();

}
