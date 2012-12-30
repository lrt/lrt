<?php

namespace Lrt\VideoBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class VideoHandler {

    protected $form;
    protected $request;
    protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->em = $em;
    }

    public function process()
    {
        if($this->request->getMethod() == 'POST')
        {
            $this->form->bind($this->request);

            if( $this->form->isValid() )
            {
                $this->onSuccess($this->form->getData());

                return true;
            }
        }

        return false;
    }

    protected function onSuccess($video)
    {
        $this->em->persist($video);
        $this->em->flush();
    }
}