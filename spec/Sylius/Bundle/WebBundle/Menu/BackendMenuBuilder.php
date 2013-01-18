<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\WebBundle\Menu;

use PHPSpec2\ObjectBehavior;

/**
 * Menu builder spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BackendMenuBuilder extends ObjectBehavior
{
    /**
     * @param Knp\Menu\FactoryInterface                         $factory
     * @param Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function let($factory, $translator)
    {
        $this->beConstructedWith($factory, $translator);
    }

    public function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\WebBundle\Menu\MenuBuilder');
    }

    public function it_should_extend_base_menu_builder()
    {
        $this->shouldHaveType('Sylius\Bundle\WebBundle\Menu\MenuBuilder');
    }
}
