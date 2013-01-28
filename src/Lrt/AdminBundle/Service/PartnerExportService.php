<?php

namespace Lrt\AdminBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Export de la liste des partenaires sur le site
 * @Service("service.export_partners")
 */
class ExportPartnerService extends ExportService
{
    public function generateCsvReadyDatas()
    {
        $partners = $this->em->getRepository('SiteBundle:Partner')->findAll();

        if (!empty($partners)) {

            foreach ($partners as $partner) {

                $dataLine = array();

                $dataLine['entreprise']     = utf8_decode($partner->getName());
                $dataLine['description']   = utf8_decode($partner->getDescription());
                $dataLine['site internet']    = utf8_decode($partner->getWebSite());

                $datas[] = $dataLine;
            }

            $this->datas = &$datas;
            $this->columns = array_keys($this->datas[0]);

            $date = new \Datetime();
            $fileName = $date->format('Ymd_His') . '_Partners';

            return $this->downloadCsv(self::TEMPORARY_DIRECTORY, $fileName);
        }

        return 0;
    }
}
