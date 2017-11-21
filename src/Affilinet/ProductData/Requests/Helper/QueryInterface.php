<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests\Helper;

interface QueryInterface
{

    /**
     * @return string
     */
    public function getQuery();

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function where(Expression $expression);

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function andWhere(Expression $expression);

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function orWhere(Expression $expression);

}
