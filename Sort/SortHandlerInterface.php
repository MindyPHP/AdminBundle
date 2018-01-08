<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Sort;

use Mindy\Orm\QuerySetInterface;

interface SortHandlerInterface
{
    /**
     * @param QuerySetInterface $source
     * @param array             $data
     *
     * @return
     */
    public function sort(QuerySetInterface $source, array $data);
}
