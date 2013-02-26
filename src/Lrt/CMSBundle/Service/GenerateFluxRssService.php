<?php

namespace Lrt\CMSBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 *
 * @DI\Service("cms.service.flux.rss")
 */
class GenerateFluxRssService
{
    /**
     * @DI\Inject("kernel")
     */
    public $kernel;

    public function generateRssArticles($datas)
    {
        $xml = '<?xml version="1.0" encoding="iso-8859-1"?><rss version="2.0">';
        $xml .= '<channel>';
        $xml .= '<title>Flux RSS - Longchamp Roller Team</title>';
        $xml .= '<link>http://www.longchamp-roller-team.com</link>';
        $xml .= '<description>Description du channel</description>';

        foreach ($datas as $data) {
            $xml .= '<item>';
            $xml .= '<title>' . $data->getTitle() . '</title>';
            $xml .= '<link>' . $data->getTitle() . '</link>';
            $xml .= '<pubDate>' . $data->getDateSubmission()->format('Ymd') . ' GMT</pubDate>';
            $xml .= '<description>' . $data->getContent() . '</description>';
            $xml .= '</item>';
        }

        $xml .= '</channel>';
        $xml .= '</rss>';

        $fp = fopen($this->kernel->getRootDir() . '/../web/rss/' . 'flux.xml', 'w+');
        fputs($fp, $xml);
        fclose($fp);

        return true;
    }
}
