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
use Mindy\Template\TemplateEngine;

class AdminMenuWidget extends AbstractWidget
{
    /**
     * @var AdminMenu
     */
    protected $adminMenu;
    /**
     * @var TemplateEngine
     */
    protected $templateEngine;

    /**
     * AdminMenuWidget constructor.
     *
     * @param AdminMenu      $adminMenu
     * @param TemplateEngine $templateEngine
     */
    public function __construct(AdminMenu $adminMenu, TemplateEngine $templateEngine)
    {
        $this->adminMenu = $adminMenu;
        $this->templateEngine = $templateEngine;
    }

    public function render(): string
    {
        return $this->templateEngine->render('admin/dashboard/menu.html', [
            'menu' => $this->adminMenu->getMenu(),
        ]);
    }
}
