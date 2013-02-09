<?php

namespace Lrt\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Finder\Finder;
use Lrt\UserBundle\Util\CsvReader;
use Lrt\UserBundle\Entity\Department;

class ImportDepartmentCommand extends ContainerAwareCommand
{
    private $entityManager;

    protected function configure()
    {
        $this->setName('user:import:department')
             ->setDescription('Import tous les départements de France')
            ->addOption(
                'csv', null, InputOption::VALUE_NONE, 'si option csv les import se font depuis un fichier csv'
            )
            ->addOption(
                'sql', null, InputOption::VALUE_NONE, 'si option sql les import se font depuis un fichier sql'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $csvFile   = 'villes.csv';

        $dialog = $this->getHelperSet()->get('dialog');
        $this->entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);

        if (!$input->getOption('csv')) {
            if (!$dialog->askConfirmation(
                $output, '<question>Cette commande va vider la table commune, voulez-vous continuer ? (Y/N)</question>', false
            )) {
                return 1;
            }
        }

        //delete table department
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('department', true /* whether to cascade */));

        if (!$input->getOption('sql')) {

            $csvFilePath = $this->getContainer()->get('kernel')->getRootDir() . '/data/' . $csvFile;

            if (!file_get_contents($csvFilePath)) {
                $output->writeln($csvFilePath . '  not found');
                return 1;
            }

            //$progress = $this->getHelperSet()->get('progress');
            //$progress->start($output, 35479);
            $batchSize = 10000;

            $csvReader = new CsvReader();
            $csvReader->open($csvFilePath, ";");

            $i = 0;
            while ($row = $csvReader->getRow()) {
                // skip rows that dont have an id
                if (($i % $batchSize) == 0) {
                    $this->import($row, true);
                } else {
                    $this->import($row, false);
                }
                ++$i;
                //$progress->advance();
            }
            $this->entityManager->flush();
            //$progress->finish();

        } else {
            $sqlFile = 'commune.sql';
            $file = __DIR__ . '/../' . $sqlFile;

            if (!file_exists($file)) {
                echo sprintf('File %s does not exists', $file);
                return;
            }
            $data = file_get_contents($file);

            $connection->executeUpdate($data);
        }

        return 0;
    }

    protected function import($row, $andFlush)
    {
        $department = new Department();
        $department->setZipCode($row[0]);
        $department->setName($row[1]);

        $this->entityManager->persist($department);
        if ($andFlush) {
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }
}
