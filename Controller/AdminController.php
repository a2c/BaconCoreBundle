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
    protected function createDeleteForm()
    {
        return $this->createFormBuilder()->add('id', 'hidden')->getForm();
    }
}
