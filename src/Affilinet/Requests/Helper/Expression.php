<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\Requests\Helper;

class Expression implements ExpressionInterface
{
    public function __construct()
    {
        return $this;
    }

    /**
     * @var string
     */
    private $expression;

    /**
     * @param $keyword string
     * @return Expression
     */
    public function exactly($keyword)
    {
        return $this->combineLiterals(['"'. $keyword . '"'], 'AND');
    }

    /**
     * @param array ...$keywords
     * @return Expression
     */
    public function containsOneOf(...$keywords)
    {
        return $this->combineLiterals($keywords, 'OR');
    }

    /**
     *
     * @param  string     $keyword
     * @return Expression
     */
    public function contains($keyword)
    {
        return $this->combineLiterals([$keyword], 'AND');
    }

    /**
     * @param  array      $keywords
     * @return Expression
     */
    public function containsAllOf(...$keywords)
    {
        return $this->combineLiterals($keywords, 'AND');

    }

    /**
     * @param  array      $keywords
     * @return Expression
     */
    public function containsNot(...$keywords)
    {
        return  $this->combineLiterals($keywords, 'NOT');

    }

    /**
     * @param $keywords
     * @param $operator
     * @return $this
     */
    private function combineLiterals($keywords, $operator)
    {

        if (count($keywords) === 1) {
            switch ($operator) {
                case 'NOT':
                    $this->expression .= ' NOT "' . $keywords[0] . '" ';

                    return $this;
            }
        }

        $string = '';

        // do not add a leading $operator
        if ($this->expression != '') {

            $string = ' ' . $operator . ' ';
        }

        if (count($keywords) < 1) {
            $string .= ' (';
        }

        $i = 0;
        foreach ($keywords as $keyword) {
            $i++;
            if ($i > 1 || $operator === 'NOT') {
                $string .= ' '. $operator . ' ';
            }

            $string .= ' '. $keyword . ' ';
        }

        if (count($keywords) < 1) {
            $string .= ')';
        }

        $this->expression  .= $string;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

}
