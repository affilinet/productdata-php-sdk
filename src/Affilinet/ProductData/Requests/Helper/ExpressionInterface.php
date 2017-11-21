<?php
/**
 * Created by PhpStorm.
 * User: standard
 * Date: 06.10.16
 * Time: 21:37
 */

namespace Affilinet\ProductData\Requests\Helper;

interface ExpressionInterface
{

    /**
     * @param $keyword string
     * @return Expression
     */
    public function exactly($keyword);

    /**
     * @param array ...$keywords
     * @return Expression
     */
    public function containsOneOf(...$keywords);

    /**
     *
     * @param  string     $keyword
     * @return Expression
     */
    public function contains($keyword);

    /**
     * @param  array      $keywords
     * @return Expression
     */
    public function containsAllOf(...$keywords);

    /**
     * @param  array      $keywords
     * @return Expression
     */
    public function containsNot(...$keywords);

    /**
     * @return string
     */
    public function getExpression();
}
