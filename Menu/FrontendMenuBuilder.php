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

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend menu builder.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FrontendMenuBuilder extends MenuBuilder
{
    /**
     * Builds frontend main menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav nav-pills pull-right'
            )
        ));

        $menu->setCurrent($request->getRequestUri());

        if ($this->securityContext->isGranted('ROLE_USER')) {
            $menu->addChild('logout', array(
                'route' => 'fos_user_security_logout'
            ))->setLabel($this->translate('sylius.frontend.menu.main.logout'));
        } else {
            $menu->addChild('register', array(
                'route' => 'fos_user_registration_register'
            ))->setLabel($this->translate('sylius.frontend.menu.main.register'));
            $menu->addChild('login', array(
                'route' => 'fos_user_security_login'
            ))->setLabel($this->translate('sylius.frontend.menu.main.login'));
        }
        if ($this->securityContext->isGranted('ROLE_SYLIUS_ADMIN')) {
            $menu->addChild('dashboard', array(
                'route' => 'sylius_backend_dashboard'
            ))->setLabel($this->translate('sylius.frontend.menu.main.dashboard'));
        }

        return $menu;
    }
}
