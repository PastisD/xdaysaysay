<?php

namespace Tissou\XdaysaysayBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zeroem\CurlBundle\Curl\Request;
use \SimpleXMLElement;
use \DateTime ;

class XdccUpdate extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('xdcc:update')
            ->setDescription('Update all xdccs contents')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();
        $xdccs = $manager->getRepository('TissouXdaysaysayBundle:Xdcc')
            ->findAll();

        foreach($xdccs as $xdcc)
        {
            $url = ( $xdcc->getServer()->getSsl() ? 'https://' : 'http://' ) . $xdcc->getServer()->getHost() . ':' . $xdcc->getServer()->getHttpPort() . $xdcc->getUrl();
            $request = new Request($url);

            $options = [CURLOPT_RETURNTRANSFER => true];
            if($xdcc->getServer()->getSsl())
            {
                $options[CURLOPT_SSL_CIPHER_LIST] = "ECDHE-ECDSA-AES256-SHA:ECDH-ECDSA-AES256-SHA:ECDHE-ECDSA-AES128-SHA:ECDH-ECDSA-AES128-SHA:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES256-SHA384:ECDH-ECDSA-AES256-GCM-SHA384:ECDH-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES128-SHA256:ECDH-ECDSA-AES128-GCM-SHA256:ECDH-ECDSA-AES128-SHA256";
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }
            $request->setOptionArray($options);

            $xml = $request->execute();
            $dom = new SimpleXMLElement( $xml );

            // Xdcc infos
            $xdcc->setPacksum($dom->sysinfo->quota->packsum);
            $xdcc->setDiskspace($dom->sysinfo->quota->diskspace);
            $xdcc->setTransferedtotal($dom->sysinfo->quota->transferedtotal);
            $xdcc->setTotaluptime($dom->sysinfo->quota->totaluptime);
            $xdcc->setLastupdate(new DateTime($dom->sysinfo->quota->lastupdate));
//            $xdcc->getPacks()->clear();

            // Packs

            $manager->persist($xdcc);
        }
        $manager->flush();
    }
}