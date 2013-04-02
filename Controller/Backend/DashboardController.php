<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Backend dashboard controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class DashboardController extends Controller
{
    /**
     * Backend dashboard display action.
     *
     * @return Response
     */
    public function mainAction()
    {
        $months = array_map(
            function($m) {
                return date('F', mktime(0, 0, 0, $m, 10));
            },
            range(1, 12)
        );

        return $this->render('SyliusWebBundle:Backend/Dashboard:main.html.twig', array(
            'charts' => array(
                'chart_order_total' => array(
                    'label' => 'Order value (€)',
                    'type' => 'Line',
                    'data' => array(
                        'labels' => $months,
                        'datasets' => array(
                            array(
                                'fillColor' => "rgba(151,187,205,0.5)",
                                'strokeColor' => "rgba(151,187,205,1)",
                                'data' => $this->get('sylius.repository.order')->getTotalStatistics()
                            )
                        )
                    )
                ),
                'chart_order_count' => array(
                    'label' => 'Number of orders',
                    'type' => 'Line',
                    'data' => array(
                        'labels' => $months,
                        'datasets' => array(
                            array(
                                'fillColor' => "rgba(151,187,205,0.5)",
                                'strokeColor' => "rgba(151,187,205,1)",
                                'data' => $this->get('sylius.repository.order')->getCountStatistics()
                            )
                        )
                    )
                )
            )
        ));
    }
}
