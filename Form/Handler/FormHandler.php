<?php

namespace Bacon\Bundle\CoreBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class FormHandler
 * @package Bacon\Bundle\CoreBundle\Form\Handler
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
abstract class FormHandler
{
    /**
     * @var FormInterface
     */
    protected $form;

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
     * @param EntityManager $em
     * @param FlashBag $flashBag
     */
    public function __construct(FormInterface $form,EntityManager $em,FlashBag $flashBag)
    {
        $this->form     = $form;
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
    public function getEntityManager()
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

    /**
     * @return bool|mixed
     */
    public function save()
    {
        if ($this->getForm()->isValid()) {

            $data = $this->getForm()->getData();

            $created = is_null($data->getId()) ? true : false;
            try {
                if ($created)
                    $this->getEntityManager()->persist($data);
                else
                    $this->getEntityManager()->merge($data);

                $this->getEntityManager()->flush();

                $this->getFlashBag()->add('message', [
                    'type' => 'success',
                    'message' => sprintf('The record has been %s successfully.', $created ? 'created' : 'updated'),
                ]);

                return $data;

            } catch (\Exception $e) {

                $this->getFlashBag()->add('message', [
                    'type' => 'error',
                    'message' => $e->getMessage(),
                ]);

                return false;
            }
        } 

        $errors = $this->getForm()->getErrors();
        
        foreach ($errors as $error) {
            $this->getFlashBag()->add('message', [
                'type' => 'error',
                'message' => $error->getMessage(),
            ]);
        }

        return false;
    }

    public function delete($entity)
    {
        try {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();

            $this->getFlashBag()->add('message', [
                'type' => 'success',
                'message' => 'The record has been remove successfully.',
            ]);
        } catch (\Exception $e) {
            $this->getFlashBag()->add('message', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

    }
}
