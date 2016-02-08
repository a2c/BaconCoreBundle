<?php

namespace Bacon\Bundle\CoreBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Security\Acl\Exception\Exception;

abstract class FormHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var FlashBag
     */
    protected $flashBag;

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param EntityManager $em
     * @param FlashBag $flashBag
     */
    public function __construct(FormInterface $form,Request $request,EntityManager $em,FlashBag $flashBag)
    {
        $this->form     = $form;
        $this->request  = $request;
        $this->em       = $em;
        $this->flashBag  = $flashBag;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @return FlashBag
     */
    public function getFlashBag()
    {
        return $this->flashBag;
    }

    public function save()
    {
        $this->getForm()->handleRequest($this->getRequest());
        if ($this->getForm()->isSubmitted() and $this->getForm()->isValid()) {

            $data = $this->getForm()->getData();

            $created = is_null($data->getId()) ? true : false;
            try {

                if ($created)
                    $this->getEm()->persist($data);
                else
                    $this->getEm()->merge($data);

                $this->getEm()->flush();

                $this->getFlashBag()->add('message', array(
                    'type' => 'success',
                    'message' => sprintf('The record has been %s successfully.', $created ? 'created' : 'updated'),
                ));

                return $data;

            } catch (\Exception $e) {

                $this->getFlashBag()->add('message', array(
                    'type' => 'error',
                    'message' => $e->getMessage(),
                ));

                return false;
            }

        } 

        $errors = $this->getForm()->getErrors();
        
        foreach ($errors as $error) {
            $this->getFlashBag()->add('message', array(
                'type' => 'error',
                'message' => $error->getMessage(),
            ));
        }

        return false;
    }
}
