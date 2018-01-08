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

use Mindy\Orm\QuerySet;
use Mindy\Orm\QuerySetInterface;

class SortHandler implements SortHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function sort(QuerySetInterface $source, array $data)
    {
        /** @var QuerySet $cloneQs */
        $cloneQs = clone $source;

        $values = $data['models'];
        $column = $data['column'];

        /*
         * Pager-independent sorting
         */
        $oldPositions = $cloneQs
            ->filter(['pk__in' => $values])
            ->valuesList([$column], true);
        asort($oldPositions);

        foreach ($values as $id) {
            (clone $source)
                ->filter(['pk' => $id])
                ->update([$column => array_shift($oldPositions)]);
        }
    }
}
