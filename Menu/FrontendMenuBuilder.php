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

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Frontend menu builder.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FrontendMenuBuilder extends MenuBuilder
{
    /**
     * Taxonomy repository.
     *
     * @var RepositoryInterface
     */
    protected $taxonomyRepository;

    /**
     * Constructor.
     *
     * @param FactoryInterface         $factory
     * @param SecurityContextInterface $securityContext
     * @param TranslatorInterface      $translator
     * @param RepositoryInterface      $taxonomyRepository
     */
    public function __construct(
        FactoryInterface         $factory,
        SecurityContextInterface $securityContext,
        TranslatorInterface      $translator,
        RepositoryInterface      $taxonomyRepository
    )
    {
        parent::__construct($factory, $securityContext, $translator);

        $this->taxonomyRepository = $taxonomyRepository;
    }

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
            $menu->addChild('administration', array(
                'route' => 'sylius_backend_dashboard'
            ))->setLabel($this->translate('sylius.frontend.menu.main.administration'));
        }

        return $menu;
    }

    /**
     * Builds frontend taxonomies menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createTaxonomiesMenu(Request $request)
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

        $taxonomies = $this->getTaxonomies();

        foreach ($taxonomies as $taxonomy) {
            $child = $menu->addChild($taxonomy->getName(), $childOptions);

            foreach ($taxonomy->getTaxons() as $taxon) {
                $child->addChild($taxon->getName(), array(
                    'route'           => 'sylius_product_index_by_taxon',
                    'routeParameters' => array('permalink' => $taxon->getPermalink()),
                ));
            }
        }

        return $menu;
    }

    /**
     * Get all taxonomies.
     *
     * @return TaxonomyInterface[]
     */
    protected function getTaxonomies()
    {
        return $this->taxonomyRepository->findAll();
    }
}
