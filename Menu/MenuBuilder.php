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
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Abstract menu builder.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
abstract class MenuBuilder
{
    /**
     * Menu factory.
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * Translator instance.
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Constructor.
     *
     * @param FactoryInterface    $factory
     * @param TranslatorInterface $translator
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->translator = $translator;
    }

    /**
     * Translate label.
     *
     * @param string $label
     *
     * @return string
     */
    protected function translate($label)
    {
        return $this->translator->trans($label);
    }
}
