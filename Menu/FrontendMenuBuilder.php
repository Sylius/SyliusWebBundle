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
use Sylius\Bundle\CartBundle\Provider\CartProviderInterface;
use Sylius\Bundle\MoneyBundle\Twig\SyliusMoneyExtension;

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
     * Cart provider.
     *
     * @var CartProviderInterface
     */
    private $cartProvider;

    /**
     * Money extension.
     *
     * @var SyliusMoneyExtension
     */
    private $moneyExtension;

    /**
     * Constructor.
     *
     * @param FactoryInterface         $factory
     * @param SecurityContextInterface $securityContext
     * @param TranslatorInterface      $translator
     * @param RepositoryInterface      $taxonomyRepository
     * @param CartProviderInterface    $cartProvider
     */
    public function __construct(
        FactoryInterface         $factory,
        SecurityContextInterface $securityContext,
        TranslatorInterface      $translator,
        RepositoryInterface      $taxonomyRepository,
        CartProviderInterface    $cartProvider,
        SyliusMoneyExtension     $moneyExtension
    )
    {
        parent::__construct($factory, $securityContext, $translator);

        $this->taxonomyRepository = $taxonomyRepository;
        $this->cartProvider = $cartProvider;
        $this->moneyExtension = $moneyExtension;
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

        // if ($this->cartProvider->hasCart()) {
            $cart = $this->cartProvider->getCart();
            $menu->addChild('cart', array(
                'route' => 'sylius_cart_summary',
                'linkAttributes' => array('title' => $this->translate('sylius.frontend.menu.main.cart')),
                'labelAttributes' => array('icon' => 'icon-shopping-cart')
            ))->setLabel(sprintf('(%s) %s', $cart->getTotalItems(), $this->moneyExtension->formatMoney($cart->getTotal())));
        // }

        if ($this->securityContext->isGranted('ROLE_USER')) {
            $menu->addChild('logout', array(
                'route' => 'fos_user_security_logout',
                'linkAttributes' => array('title' => $this->translate('sylius.frontend.menu.main.logout')),
                'labelAttributes' => array('icon' => 'icon-off', 'iconOnly' => true)
            ));
        } else {
            $menu->addChild('login', array(
                'route' => 'fos_user_security_login',
                'linkAttributes' => array('title' => $this->translate('sylius.frontend.menu.main.login')),
                'labelAttributes' => array('icon' => 'icon-lock', 'iconOnly' => true)
            ));
            $menu->addChild('register', array(
                'route' => 'fos_user_registration_register',
                'linkAttributes' => array('title' => $this->translate('sylius.frontend.menu.main.register')),
                'labelAttributes' => array('icon' => 'icon-user', 'iconOnly' => true)
            ));
        }

        if ($this->securityContext->isGranted('ROLE_SYLIUS_ADMIN')) {
            $menu->addChild('administration', array(
                'route' => 'sylius_backend_dashboard',
                'linkAttributes' => array('title' => $this->translate('sylius.frontend.menu.main.administration')),
                'labelAttributes' => array('icon' => 'icon-briefcase', 'iconOnly' => true)
            ));
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
            'labelAttributes'    => array('class' => 'nav-header'),
        );

        $taxonomies = $this->taxonomyRepository->findAll();

        foreach ($taxonomies as $taxonomy) {
            $child = $menu->addChild($taxonomy->getName(), $childOptions);

            foreach ($taxonomy->getTaxons() as $taxon) {
                $leaf = $child->addChild($taxon->getName(), array(
                    'route'           => 'sylius_product_index_by_taxon',
                    'routeParameters' => array('permalink' => $taxon->getPermalink()),
                  ));

                foreach ($taxon->getChildren() as $childTaxon) {
                    $leaf->addChild($childTaxon->getName(), array(
                        'route'           => 'sylius_product_index_by_taxon',
                        'routeParameters' => array('permalink' => $childTaxon->getPermalink()),
                    ));
                }
            }
        }

        return $menu;
    }
}
