<?php

namespace Bacon\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BreadcrumbsExtension
 * @package Bacon\Bundle\CoreBundle\Twig\Extension
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class BreadcrumbsExtension extends \Twig_Extension
{
    const TEMPLATE = 'BaconCoreBundle:partial:breadcrumbs.html.twig';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Twig_Environment
     */
    protected $enviroment;

    /**
     * @var array
     */
    protected $parameter = array();

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

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
