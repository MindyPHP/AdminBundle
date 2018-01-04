<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Controller;

use Mindy\Bundle\AdminBundle\Dashboard\Registry;
use Mindy\Bundle\MindyBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function list(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $registry = $this->get(Registry::class);

        return $this->render('admin/dashboard/index.html', [
            'widgets' => $registry->all(),
        ]);
    }
}
