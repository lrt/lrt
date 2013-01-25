<?php

namespace Lrt\AdminBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Export de la liste des articles du site
 * @Service("service.export_articles")
 */
class ArticleExportService extends ExportService
{
    public function generateCsvReadyDatas()
    {
        $articles = $this->em->getRepository('CMSBundle:Article')->findAll();

        if (!empty($articles)) {

            foreach ($articles as $article) {

                $dataLine = array();

                $dataLine['title']     = utf8_decode($article->getTitle());
                $dataLine['content']   = utf8_decode($article->getContent());
                $dataLine['auteur']    = utf8_decode($article->getUser()->getUsername());

                $datas[] = $dataLine;
            }

            $this->datas = &$datas;
            $this->columns = array_keys($this->datas[0]);

            $date = new \Datetime();
            $fileName = $date->format('Ymd_His') . '_Articles';

            return $this->downloadCsv(self::TEMPORARY_DIRECTORY, $fileName);
        }

        return 0;
    }
}
