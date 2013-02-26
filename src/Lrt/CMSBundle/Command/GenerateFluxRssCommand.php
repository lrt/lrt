<?php

namespace Lrt\CMSBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFluxRssCommand extends ContainerAwareCommand
{
    private $entityManager;

    protected function configure()
    {
        $this->setName('cms:generate:rss')
            ->setDescription('Lance le script pour générer le flux RSS');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager = $this->getContainer()->get('doctrine')->getEntityManager();
        $fluxRSSService = $this->getContainer()->get('cms.service.flux.rss');

        $articles = $this->entityManager->getRepository('CMSBundle:Article')->findAll();

        $result = $fluxRSSService->generateRssArticles($articles);

        if ($result == true) {
            $output->writeln('Operation reussi.');
        } else {
            $output->writeln('Echec de l\'operation');
        }
    }
}
