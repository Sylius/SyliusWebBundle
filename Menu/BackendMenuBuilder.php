<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Menu;

use Symfony\Component\HttpFoundation\Request;

/**
 * Main menu builder.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BackendMenuBuilder extends MenuBuilder
{
    /**
     * Builds backend main menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($request->getRequestUri());

        $menu->addChild('dashboard', array(
            'route' => 'sylius_backend_dashboard'
        ))->setLabel($this->translate('sylius.backend.menu.main.dashboard'));

        $menu->addChild('homepage', array(
            'route' => 'sylius_homepage'
        ))->setLabel($this->translate('sylius.backend.menu.main.homepage'));

        return $menu;
    }

    /**
     * Builds backend sidebar menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createSidebarMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $menu->setCurrent($request->getRequestUri());

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav nav-list'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $child = $menu->addChild('Sylius', $childOptions);

        $child->addChild('dashboard', array(
            'route' => 'sylius_backend_dashboard',
        ))->setLabel($this->translate('sylius.backend.menu.sidebar.dashboard'));

        $child->addChild('homepage', array(
            'route' => 'sylius_homepage'
        ))->setLabel($this->translate('sylius.backend.menu.sidebar.homepage'));

        return $menu;
    }
}
