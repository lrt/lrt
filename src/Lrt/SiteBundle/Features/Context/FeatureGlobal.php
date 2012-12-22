<?php

namespace Lrt\SiteBundle\Features\Context;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Symfony2Extension\Context\KernelAwareInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Exception\ExpectationException;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureGlobal extends MinkContext
{

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        
    }

    /**
     * Test le contenu des reponses des exports CSV
     * 
     * @Then /^la réponse devrait contenir un CSV :$/
     */
    public function laReponseDevraitContenirUnCSV(PyStringNode $text)
    {
        $actual = utf8_encode($this->getSession()->getPage()->getContent());
        $regex = '/'.preg_quote($text, '/').'/ui';

        if (!preg_match($regex, $actual)) {
            $message = sprintf('The string "%s" was not found anywhere in the HTML response of the current page.', $text);
            throw new ExpectationException($message, $this->getSession());
        }
    }

    /**
     * @Given /^je ne devrais pas voir les lignes suivantes dans le tableau "([^"]*)" :$/
     */
    public function jeNeDevraisPasVoirLesLignesSuivantesDansLeTableau($tableClass, TableNode $table)
    {
        $result = $this->isLineInFile($tableClass, $table);

        if ($result == true) {
            $message = sprintf('The line was found in the HTML response of the current page (and it should not !)');
            throw new ExpectationException($message, $this->getSession());
        }
    }

    /**
     * @Given /^je devrais voir les lignes suivantes dans le tableau "([^"]*)" :$/
     */
    public function jeDevraisVoirLesLignesSuivantesDansLeTableau($tableClass, TableNode $table)
    {
        $result = $this->isLineInFile($tableClass, $table);

        if ($result == false) {
            $message = sprintf('The line was not found anywhere in the HTML response of the current page.');
            throw new ExpectationException($message, $this->getSession());
        }
    }

    protected function isLineInFile($tableClass, TableNode $table)
    {
        $rows = $table->getRows();
        $line = $rows[0];

        $trTableau = $this->getSession()->getPage()->findAll('css', 'table.'.$tableClass.' tr');

        $htmlTableContent = array();
        foreach ($trTableau as $trElement) {
            $htmlLineContent = array();
            $tdTableau = $trElement->findAll('css', 'td');
            foreach ($tdTableau as $tdElement) {
                $htmlLineContent[] = trim($tdElement->getHtml());
            }
            $htmlTableContent[] = $htmlLineContent;
        }

        //var_dump($htmlTableContent);
        $lineFound = false;

        foreach ($htmlTableContent as $htmlLineContent) {
            $found = true;
            foreach ($line as $k => $cell) {
                if ((trim($cell) == "*" || (isset($htmlLineContent[$k]) && trim($cell) == $htmlLineContent[$k])) && $found == true) {
                    $found = true;
                } else {
                    $found = false;
                }
            }
            if ($found == true) {
                $lineFound = true;
            }
        }

        return $lineFound;
    }

    /**
     * @Given /^je clique sur le lien "([^"]*)" contenu dans la ligne "([^"]*)" du tableau "([^"]*)"$/
     */
    public function jeCliqueSurLeLienContenuDansLaLigneDuTableau($arg1, $arg2, $arg3)
    {
        $lignesTableau = $this->getSession()->getPage()->findAll('css', 'table.'.$arg3.' tbody tr');
        $trouve = false;

        $ligneX = $lignesTableau[$arg2 - 1];

        $cols = $ligneX->findAll('css', 'td');
        foreach ($cols as $col) {
            $liens = $col->findAll('css', 'a');
            /* @var $lienElement \Behat\Mink\Element\NodeElement */
            foreach ($liens as $lienElement) {
                if (strpos($lienElement->getHtml(), $arg1) !== false) {
                    $lienElement->click();
                    $trouve = true;
                    break 2;
                }
            }
        }

        assertEquals($trouve, true, '"'.$arg1.'" non trouvé');
    }

    /**
     * @Given /^le tableau "([^"]*)" devrait etre vide$/
     */
    public function leTableauDevraitEtreVide($tableau)
    {
        $lignesTableau = $this->getSession()->getPage()->findAll('css', 'table.'.$tableau.' tbody tr');

        if (empty($lignesTableau)) {
            return true;
        }
        return false;
    }

}
