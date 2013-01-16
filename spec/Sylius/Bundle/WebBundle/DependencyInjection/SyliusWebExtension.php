<?php

namespace spec\Sylius\Bundle\WebBundle\DependencyInjection;

use PHPSpec2\ObjectBehavior;

/**
 * Sylius web frontend container extension spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusWebExtension extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\WebBundle\DependencyInjection\SyliusWebExtension');
    }

    function it_should_be_container_extension()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\DependencyInjection\Extension');
    }
}
