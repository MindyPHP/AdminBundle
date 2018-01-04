<?php

declare(strict_types=1);

/*
 * This file is part of Mindy Framework.
 * (c) 2018 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\AdminBundle\TemplateFinder;

use Mindy\Template\Finder\ChainFinder;

/**
 * Class TemplateFinder.
 */
class AdminTemplateFinder
{
    /**
     * Default admin template paths for easy override.
     *
     * @var array
     */
    public $paths = [
        '{bundle}/admin/{admin}/{template}',
        'admin/{bundle}/{admin}/{template}',
        'admin/admin/{template}',
        'admin/{template}',
    ];
    /**
     * @var ChainFinder
     */
    protected $finder;

    /**
     * TemplateFinder constructor.
     *
     * @param ChainFinder $finder
     */
    public function __construct(ChainFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param $str
     *
     * @return string
     */
    protected function normalizeString($str)
    {
        return trim(strtolower(preg_replace('/(?<![A-Z])[A-Z]/', '_\0', $str)), '_');
    }

    /**
     * @param $bundleName
     * @param $adminName
     * @param $template
     *
     * @return string
     */
    public function findTemplate($bundleName, $adminName, $template)
    {
        foreach ($this->paths as $pathTemplate) {
            $path = strtr($pathTemplate, [
                '{bundle}' => strtolower(str_replace('Bundle', '', $bundleName)),
                '{admin}' => strtolower($this->normalizeString(str_replace('Admin', '', $adminName))),
                '{template}' => $template,
            ]);

            if ($this->finder->find($path)) {
                return $path;
            }
        }

        return null;
    }
}
