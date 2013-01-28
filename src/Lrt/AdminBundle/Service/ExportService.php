<?php

namespace Lrt\AdminBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Service("service.export.csv")
 */
class ExportService
{
    CONST TEMPORARY_DIRECTORY = 'app/tmp/';

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;
    public $datas;
    public $columns;

    public function downloadCsv($filePath, $fileName)
    {
        $response = new Response();
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Expires', 0);
        $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Content-Type', 'text/csv; charset=iso-8859-1');
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '.csv"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        $filepath = $this->generateCsv($filePath, 'tmp');

        $response->setContent(file_get_contents($filepath));

        unlink($filepath);

        return $response;
    }

    public function generateCsv($filePath, $fileName)
    {
        $filepath = '/../../../../' . $filePath . $fileName . '.csv';

        $filepath = __DIR__ . $filepath;
        $fp = fopen($filepath, 'w');

        foreach ($this->columns as $k => $c) {
            $this->columns[$k] = utf8_decode($this->columns[$k]);
        }

        fputcsv($fp, $this->columns, ';', '"');

        foreach ($this->datas as $line) {
            fputcsv($fp, $line, ';', '"');
        }

        fclose($fp);

        return $filepath;
    }
}
