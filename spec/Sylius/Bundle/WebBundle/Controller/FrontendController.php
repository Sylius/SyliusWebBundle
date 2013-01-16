<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\WebBundle\Controller;

use PHPSpec2\ObjectBehavior;

/**
 * Frontend controller spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FrontendController extends ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param Symfony\Component\Templating\EngineInterface             $templating
     * @param Symfony\Component\HttpFoundation\Response                $response
     */
    function let($container, $templating, $response)
    {
        $container->get('templating')->willReturn($templating);

        $this->setContainer($container);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\WebBundle\Controller\FrontendController');
    }

    function it_should_be_a_controller()
    {
        $this->shouldHaveType('Symfony\Bundle\FrameworkBundle\Controller\Controller');
    }

    function its_indexAction_should_render_frontend_index_page($templating, $response)
    {
        $templating->renderResponse('SyliusWebBundle:Frontend:index.html.twig', array(), ANY_ARGUMENT)->willReturn($response)->shouldBeCalled();

        $this->indexAction()->shouldReturn($response);
    }
}
