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

use Symfony\Component\Routing\RouterInterface;

class AdminMenu
{
    /**
     * @var array
     */
    protected $menu = [];

    /**
     * AdminMenu constructor.
     *
     * @param RouterInterface $router
     * @param array $nodes
     */
    public function __construct(RouterInterface $router, array $nodes)
    {
        foreach ($nodes as $node) {
            $this->menu[] = new AdminMenuNode($router, $node);
        }
    }

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return $this->menu;
    }
}
