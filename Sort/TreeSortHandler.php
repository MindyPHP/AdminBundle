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
use Mindy\Orm\TreeModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TreeSortHandler implements SortHandlerInterface
{
    /**
     * Set new root for all children nodes in tree
     *
     * @param TreeModel $model
     * @param array     $values
     */
    protected function sortRoots(TreeModel $model, array $values)
    {
        $roots = $model
            ->objects()
            ->roots()
            ->filter(['pk__in' => $values])
            ->all();

        $newPositions = array_flip($values);

        foreach ($roots as $root) {
            /** @var TreeModel $root */
            $descendantIds = $root
                ->objects()
                ->descendants()
                ->filter(['level__gt' => 1])
                ->valuesList(['pk'], true);

            if (count($descendantIds) > 0) {
                $model
                    ->objects()
                    ->filter(['pk__in' => $descendantIds])
                    ->update(['root' => $newPositions[$root->pk]]);
            }
        }

        foreach ($newPositions as $pk => $position) {
            $model
                ->objects()
                ->filter(['pk' => $pk])
                ->update(['root' => $position]);
        }
    }

    /**
     * Simple sorting children nodes by lft / rgt
     *
     * @param TreeModel $model
     * @param null      $before
     * @param null      $after
     */
    protected function sortChildren(TreeModel $model, $before = null, $after = null)
    {
        /* @var TreeModel $target */
        if (false === empty($before)) {
            $target = $model->objects()->get([
                'pk' => $before,
            ]);
            if (null === $target) {
                throw new NotFoundHttpException('Target not found');
            }

            $model->moveBefore($target);
        } elseif (false === empty($after)) {
            $target = $model->objects()->get([
                'pk' => $after,
            ]);
            if (null === $target) {
                throw new NotFoundHttpException('Target not found');
            }

            $model->moveAfter($target);
        } else {
            throw new NotFoundHttpException('Missing required parameter insertAfter or insertBefore');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sort(QuerySetInterface $source, array $data)
    {
        if (false === isset($data['id'])) {
            throw new \RuntimeException('Failed to receive primary key');
        }

        $pk = $data['id'];

        /** @var TreeModel $model */
        $model = $source->getModel()->objects()->get(['pk' => $pk]);
        if (null === $model) {
            throw new NotFoundHttpException('Model not found');
        }

        if ($model->getIsRoot()) {
            $this->sortRoots($model, $data['models']);
        } else {
            $this->sortChildren($model, $data['before'], $data['after']);
        }
    }
}
