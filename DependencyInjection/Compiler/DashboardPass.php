<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\DependencyInjection\Compiler;

use Mindy\Bundle\AdminBundle\Dashboard\Registry;
use Mindy\Bundle\AdminBundle\Dashboard\WidgetInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DashboardPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(Registry::class)) {
            return;
        }

        $container
            ->registerForAutoconfiguration(WidgetInterface::class)
            ->setPublic(true)
            ->addTag('dashboard.widget');

        $definition = $container->getDefinition(Registry::class);
        foreach ($container->findTaggedServiceIds('dashboard.widget') as $id => $params) {
            $definition->addMethodCall('add', [
                new Reference($id)
            ]);
        }
    }
}
