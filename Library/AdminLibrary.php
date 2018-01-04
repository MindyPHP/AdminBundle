<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Library;

use Mindy\Bundle\AdminBundle\Menu\AdminMenu;
use Mindy\Template\Library\AbstractLibrary;
use Mindy\Template\TemplateEngine;

class AdminLibrary extends AbstractLibrary
{
    /**
     * @var AdminMenu
     */
    protected $adminMenu;
    /**
     * @var TemplateEngine
     */
    protected $templateEngine;

    public function __construct(AdminMenu $adminMenu, TemplateEngine $templateEngine)
    {
        $this->adminMenu = $adminMenu;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @return array
     */
    public function getHelpers()
    {
        return [
            'admin_menu' => function ($template = 'admin/_menu.html') {
                return $this->templateEngine->render($template, [
                    'adminMenu' => $this->adminMenu->getMenu(),
                ]);
            },
        ];
    }
}
