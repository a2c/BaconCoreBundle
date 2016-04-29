<?php

namespace Bacon\Bundle\CoreBundle\Twig\Extension;


/**
 * Class FormExtension
 * @package Bacon\Bundle\CoreBundle\Twig\Extension
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 * @version 1.0
 */
class FormExtension extends \Twig_Extension implements \Twig_Extension_InitRuntimeInterface
{

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_bottom_info', [$this, 'getFormInfoBottomInfo'], ['is_safe' => array('html')]),
        ];
    }

    public function getFormInfoBottomInfo($message)
    {
        return '
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-12">
                <span class="text-muted"><em><span style="color:red;">*</span> '. $message .'</em></span>
            </div>
        </div>    
       ';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bacon_form_extension';
    }


}