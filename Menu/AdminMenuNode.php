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

use Mindy\Menu\MenuNode;
use Symfony\Component\Routing\RouterInterface;

class AdminMenuNode extends MenuNode
{
    /**
     * @var RouterInterface
     */
    protected $router;
    /**
     * @var string
     */
    protected $icon;
    /**
     * @var string
     */
    protected $route;
    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * AdminMenuNode constructor.
     *
     * @param RouterInterface $router
     * @param array           $properties
     */
    public function __construct(RouterInterface $router, array $properties = [])
    {
        $this->router = $router;

        if (array_key_exists('route', $properties)) {
            $this->setRoute($properties['route']);
        }

        if (array_key_exists('icon', $properties)) {
            $this->setIcon($properties['icon']);
        }

        parent::__construct($properties);
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param array $node
     *
     * @return MenuNode
     */
    public function createMenuNode(array $node)
    {
        return new self($this->router, $node);
    }

    /**
     * @param array|string $route
     */
    public function setRoute($route)
    {
        if (is_array($route)) {
            if (count($route) === 2) {
                list($this->route, $this->parameters) = $route;
            } else {
                list($this->route) = $route;
            }
        } else {
            $this->route = $route;
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (false === empty($this->route)) {
            return $this->router->generate($this->route, $this->parameters);
        }

        return parent::getUrl();
    }
}
