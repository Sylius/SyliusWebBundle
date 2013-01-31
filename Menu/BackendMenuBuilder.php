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

        $childOptions = array(
            'attributes'         => array('class' => 'dropdown'),
            'childrenAttributes' => array('class' => 'dropdown-menu'),
            'labelAttributes'    => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'href' => '#')
        );

        $menu->addChild('dashboard', array(
            'route' => 'sylius_backend_dashboard'
        ))->setLabel($this->translate('sylius.backend.menu.main.dashboard'));

        $this->addAssortmentMenu($menu, $childOptions, 'main');
        $this->addConfigurationMenu($menu, $childOptions, 'main');

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

        $this->addAssortmentMenu($menu, $childOptions, 'sidebar');
        $this->addConfigurationMenu($menu, $childOptions, 'sidebar');

        $child->addChild('homepage', array(
            'route' => 'sylius_homepage'
        ))->setLabel($this->translate('sylius.backend.menu.sidebar.homepage'));

        return $menu;
    }

    /**
     * Add assortment menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addAssortmentMenu(ItemInterface $menu, array $childOptions, $section)
    {
        $child = $menu
            ->addChild('assortment', $childOptions)
            ->setLabel($this->translate(sprintf('sylius.backend.menu.%s.assortment', $section)))
        ;

        $child->addChild('products', array(
            'route' => 'sylius_backend_product_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.products', $section)));

        $child->addChild('stockables', array(
            'route' => 'sylius_backend_stockable_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.stockables', $section)));

        $child->addChild('options', array(
            'route' => 'sylius_backend_option_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.options', $section)));

        $child->addChild('properties', array(
            'route' => 'sylius_backend_property_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.properties', $section)));

        $child->addChild('prototypes', array(
            'route' => 'sylius_backend_prototype_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.prototypes', $section)));
    }

    /**
     * Add configuration menu.
     *
     * @param ItemInterface $menu
     * @param array         $childOptions
     */
    protected function addConfigurationMenu(ItemInterface $menu, array $childOptions, $section)
    {
        $child = $menu
            ->addChild('configuration', $childOptions)
            ->setLabel($this->translate(sprintf('sylius.backend.menu.%s.configuration', $section)))
        ;

        $child->addChild('tax_categories', array(
            'route' => 'sylius_backend_tax_category_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.tax_categories', $section)));

        $child->addChild('tax_rates', array(
            'route' => 'sylius_backend_tax_rate_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.tax_rates', $section)));

        $child->addChild('shipping_categories', array(
            'route' => 'sylius_backend_shipping_category_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.shipping_categories', $section)));

        $child->addChild('shipping_methods', array(
            'route' => 'sylius_backend_shipping_method_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.shipping_methods', $section)));

        $child->addChild('countries', array(
            'route' => 'sylius_backend_country_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.countries', $section)));

        $child->addChild('zones', array(
            'route' => 'sylius_backend_zone_index',
        ))->setLabel($this->translate(sprintf('sylius.backend.menu.%s.zones', $section)));
    }
}
