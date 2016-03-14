<?php

namespace Bacon\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\SerializerBuilder as Serializer;
use JMS\Serializer\SerializationContext;

use FOS\RestBundle\Controller\FOSRestController;
use Datetime;

/**
 * Language controller.
 *
 * @version 0.1
 *
 */
class BaseController extends FOSRestController
{
    public function getContext($groups)
    {
        $groups[] = 'base';
        $context = SerializationContext::create();
        return $context->setGroups($groups);
    }

    public function takeOutAccents($string)
    {
        $patterns[0] = '/[Ã¡|Ã¢|Ã |Ã¥|Ã¤]/';
        $patterns[1] = '/[Ã°|Ã©|Ãª|Ã¨|Ã«]/';
        $patterns[2] = '/[Ã­|Ã®|Ã¬|Ã¯]/';
        $patterns[3] = '/[Ã³|Ã´|Ã²|Ã¸|Ãµ|Ã¶]/';
        $patterns[4] = '/[Ãº|Ã»|Ã¹|Ã¼]/';
        $patterns[5] = '/Ã¦/';
        $patterns[6] = '/Ã§/';
        $patterns[7] = '/ÃŸ/';
        $replacements[0] = 'a';
        $replacements[1] = 'e';
        $replacements[2] = 'i';
        $replacements[3] = 'o';
        $replacements[4] = 'u';
        $replacements[5] = 'ae';
        $replacements[6] = 'c';
        $replacements[7] = 'ss';
        
        return preg_replace($patterns, $replacements,$string);
    }
    
    public function saveEntity($entityName, $request, $id = null)
    {
        if ($id) {
           $request->request->add(array('id' => $id));
        }

        $data = json_encode($request->request->all());
        $serializer = $this->container->get('jms_serializer');
        $entity = $serializer->deserialize($data, $entityName, 'json');

        if(!$entity->getCreatedAt())
        {
            $entity->setCreatedAt(new Datetime());
        }
        
        $entity->setUpdatedAt(new Datetime());

        return $entity;
    }
}