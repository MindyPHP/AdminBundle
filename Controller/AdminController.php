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

use Mindy\Bundle\AdminBundle\Form\LoginForm;
use Mindy\Bundle\MindyBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @param Response $response
     *
     * @return Response
     */
    protected function preventCache(Response $response): Response
    {
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }

    public function login()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [], [
            'method' => 'POST',
            'action' => $this->generateUrl('admin_login'),
        ]);

        $response = $this->render('admin/auth/login.html', [
            'last_username' => $lastUsername,
            'form' => $form->createView(),
            'error' => $error,
        ]);

        return $this->preventCache($response);
    }

    public function logout()
    {
    }
}
