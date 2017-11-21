<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests;

use Affilinet\ProductData\Responses\ShopsResponseInterface;

/**
 * Class ShopsRequestInterface
 */
interface ShopsRequestInterface extends RequestInterface
{
    /**
     * @return ShopsResponseInterface
     */
    public function send();

    /**
     * @param  \DateTime $date
     * @return $this;
     */
    public function onlyShopsUpdatedAfter(\DateTime $date);

    /**
     * @param  string $keyword
     * @return $this;
     */
    public function onlyShopsMatchingKeyword($keyword);

}
