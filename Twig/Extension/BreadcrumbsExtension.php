<?php

namespace Bacon\Bundle\CoreBundle\Twig\Extension;

/**
 * Class BreadcrumbsExtension
 * @package Bacon\Bundle\CoreBundle\Twig\Extension
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class BreadcrumbsExtension extends \Twig_Extension
{
    const TEMPLATE = 'BaconCoreBundle:partial:breadcrumbs.html.twig';

    /**
     * @var \Twig_Environment
     */
    protected $enviroment;

    /**
     * @var array
     */
    protected $parameter = array();

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('bacon_breadcrumbs_render', array($this, 'getRenderView'), array(
                'is_safe' => array('html'),
                'needs_environment' => true
            ))
        ];
    }

    /**
     * @return \Twig_Environment
     */
    public function getRenderView(\Twig_Environment $twig)
    {
        return $twig->render(self::TEMPLATE,[
            'itens' => $this->parameter
        ]);
    }

    /**
     * @param $item array
     *
     * @example
     * [
     *    title : 'Home',
     *    route: 'bacon_home',
     *    parameters: [
     *        id: 1
     *    ]
     * ]
     */
    public function addItem($item)
    {
        $this->parameter[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bacon_admin_breadcrumbs';
    }
}
