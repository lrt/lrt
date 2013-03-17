<?php

namespace Lrt\CarmaBundle\Service;

use \Symfony\Component\Form\Form;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * 
 * @DI\Service("carma.service.formError")
 */
class FormErrorService
{

    public function getAllFormErrorMessages(Form $form)
    {
        $errors = array();

        if ($form->hasErrors()) {
            $errs = $form->getErrors();
            foreach ($errs as $error) {
                $errors[] = $error->getMessage();
            }
        }

        $children = $form->getChildren();
        foreach ($children as $child) {
            if ($child->hasErrors()) {
                $errs = $child->getErrors();
                foreach ($errs as $error) {
                    $errors[] = $error->getMessage();
                }
            }
        }
        return $errors;
    }

}

