<?php

namespace Bacon\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

abstract class AdminController extends Controller
{
    /**
     * @return \Knp\Component\Pager\Paginator
     */
    protected function getPagination($query,$page,$perPage)
    {
        return $this->get('knp_paginator')->paginate(
            $query,
            $page,
            $perPage
        );
    }

    /**
     * @return \Bacon\Bundle\CoreBundle\Twig\Extension\BreadcrumbsExtension
     */
    protected function getBreadcrumbs()
    {
        return $this->get('bacon_breadcrumbs');
    }

    /**
     * Cria um formulário para deletar um registro da base de dados.
     *
     * @return Form
     */
    protected function createDeleteForm($routerName = null ,$entity = null)
    {
        $form =  $this
            ->createFormBuilder()
            ->setMethod('DELETE')
        ;

        if (!is_null($routerName) && !is_null($entity)) {
            $form->setAction($this->generateUrl($routerName, array('id' => $entity->getId())));
        }

        return $form->getForm();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface|\Symfony\Component\HttpFoundation\Session\SessionBagInterface
     */
    protected function getFlashBag()
    {
        return $this->get('session')->getFlashBag();
    }
}
