<?php

namespace Lrt\AdminBundle\Service;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Export de la liste des utilisateurs du site
 * @Service("service.export_users")
 */
class UserExportService extends ExportService
{
    public function generateCsvReadyDatas()
    {
        $users = $this->em->getRepository('UserBundle:User')->findAll();

        if (!empty($users)) {

            foreach ($users as $user) {

                $dataLine = array();

                $dataLine['identifiant'] = utf8_decode($user->getUsername());
                $dataLine['prénom']      = utf8_decode($user->getFirstName());
                $dataLine['nom']         = utf8_decode($user->getLastName());
                $dataLine['email']       = utf8_decode($user->getEmail());

                $datas[] = $dataLine;
            }

            $this->datas = &$datas;
            $this->columns = array_keys($this->datas[0]);

            $date = new \Datetime();
            $fileName = $date->format('Ymd_His') . '_Users';

            return $this->downloadCsv(self::TEMPORARY_DIRECTORY, $fileName);
        }

        return 0;
    }
}
