<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\RouterInterface;

class LoginForm extends AbstractType
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * AuthForm constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_target_path', HiddenType::class, [
                'data' => $this->router->generate('admin_dashboard_index'),
            ])
            ->add('_username', TextType::class, [
                'label' => 'Имя пользователя',
                'required' => true,
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Пароль',
                'required' => true,
            ])
            ->add('_remember', CheckboxType::class, [
                'label' => 'Запомнить',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Вход',
            ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
