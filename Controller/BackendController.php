<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Backend main controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BackendController extends Controller
{
    /**
     * Store front page.
     *
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render('SyliusWebBundle:Backend:dashboard.html.twig');
    }
}
