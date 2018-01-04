<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Dashboard;

class Registry
{
    /**
     * @var array
     */
    protected $widgets = [];

    /**
     * @param WidgetInterface $widget
     */
    public function add(WidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    /**
     * @return WidgetInterface[]
     */
    public function all(): array
    {
        return $this->widgets;
    }
}
