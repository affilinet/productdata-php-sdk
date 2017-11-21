<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests\Helper;

/**
 * Class QueryBuilderTrait
 *
 * The keyword(s) you want the products to match. Can be any
 * length. The following search operators are supported:
 *      - AND (both query tokens must be contained in the product, but not necessarily next to one another)
 *      - OR (any of the query tokens must be contained in the product)
 *      - NOT (e.g. with “ipod AND NOT nano”, you will get products, which match the query “ipod”, but at the same time don’t match “nano”)
 *      - "(phrase match: all query tokens inclosed with double quotes must be contained in the found products in that order)
 *      - () Parentheses, to group expressions So you can formulate a query like this: "apple ipod" ((touch OR classic) NOT nano) AND "32  GB"
 *
 * SearchProducts supports the wildcard ‘*’ for suffix matching, that
 * is: a query ‘bott*’ will match for products, which contain the word
 * “bottle” or the word “bottom”.
 * Search operators “AND”, “OR” and “NOT” must be in capital
 * letters.
 *
 *  */
class Query implements QueryInterface
{

    private $query = '';

    /**
     * @return string
     */
    public function getQuery()
    {
       return $this->query;
    }

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function where(Expression $expression, $operator = 'AND')
    {
        if ($this->query != '') {
            $this->query .= ' '. $operator . ' ';
        }
        $this->query .=  ' (' . $expression->getExpression() . ' ) ';

        return $this;
    }

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function andWhere(Expression $expression)
    {
        return $this->where($expression, 'AND');

    }

    /**
     * @param  Expression     $expression
     * @return QueryInterface
     */
    public function orWhere(Expression $expression)
    {
        return $this->where($expression, 'OR');

    }

    public function expr()
    {
        return new Expression();
    }

}
