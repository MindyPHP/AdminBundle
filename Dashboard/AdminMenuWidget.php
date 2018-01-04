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

use Mindy\Bundle\AdminBundle\Menu\AdminMenu;

class AdminMenuWidget extends AbstractWidget
{
    /**
     * @var AdminMenu
     */
    protected $adminMenu;

    /**
     * AdminMenuWidget constructor.
     *
     * @param AdminMenu $adminMenu
     */
    public function __construct(AdminMenu $adminMenu)
    {
        $this->adminMenu = $adminMenu;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return 'admin/dashboard/menu.html';
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'adminMenu' => $this->adminMenu->getMenu(),
        ];
    }
}
