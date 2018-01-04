<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Menu;

use Mindy\Menu\Generator;

class AdminMenu
{
    /**
     * @var array
     */
    protected $menu = [];

    /**
     * AdminMenu constructor.
     *
     * @param array $nodes
     */
    public function __construct(array $nodes)
    {
        $this->menu = iterator_to_array(Generator::fromArray($nodes));
    }

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return $this->menu;
    }
}
