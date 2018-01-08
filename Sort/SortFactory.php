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
use Mindy\Orm\TreeManager;
use Mindy\Orm\TreeQuerySet;

class SortFactory
{
    /**
     * @var SortHandler
     */
    protected $sortHandler;
    /**
     * @var TreeSortHandler
     */
    protected $treeSortHandler;

    /**
     * Factory constructor.
     *
     * @param SortHandler     $sortHandler
     * @param TreeSortHandler $treeSortHandler
     */
    public function __construct(SortHandler $sortHandler, TreeSortHandler $treeSortHandler)
    {
        $this->sortHandler = $sortHandler;
        $this->treeSortHandler = $treeSortHandler;
    }

    /**
     * @param array             $data
     * @param QuerySetInterface $source
     */
    public function sort($source, array $data)
    {
        if (empty($data)) {
            return;
        }

        if ($source instanceof TreeManager || $source instanceof TreeQuerySet) {
            $this->treeSortHandler->sort($source, $data);
        } elseif ($source instanceof QuerySetInterface) {
            $this->sortHandler->sort($source, $data);
        } else {
            throw new \RuntimeException('Unknown source type');
        }
    }
}
