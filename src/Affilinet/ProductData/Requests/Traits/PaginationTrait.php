<?php

/*
 * This file is part of the affilinet Product Data PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Affilinet\ProductData\Requests\Traits;

trait PaginationTrait
{

    /**
     * @param  int   $pageNumber
     * @return $this
     */
    public function page($pageNumber = 1)
    {
        if (!is_numeric($pageNumber) || $pageNumber != intval($pageNumber) || $pageNumber === 0 || $pageNumber >= 50000) {
            throw new \InvalidArgumentException('Parameter page is not valid. The page has to be an integer value greater than 0 and less than 50000.');
        }

        $this->queryParams['CurrentPage'] = $pageNumber;

        return $this;
    }

    /**
     * @param  int   $pageSize
     * @return $this
     */
    public function pageSize($pageSize = 10)
    {
        if ($pageSize < 1 || $pageSize > 500) {
            throw new \InvalidArgumentException('PageSize is not valid. The PageSize has to be greater than 0 and less than 500.');
        }
        $this->queryParams['PageSize'] = $pageSize;

        return $this;
    }
}
