<?php

namespace Lrt\CMSBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class ArticleHandler
{

    protected $form;
    protected $request;
    protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    public function process()
    {
        if ($this->request->getMethod() == 'POST') {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($this->form->getData());

                return true;
            }
        }
    }

    protected function onSuccess($article)
    {
        $this->em->persist($article);
        $this->em->flush();
    }
}
