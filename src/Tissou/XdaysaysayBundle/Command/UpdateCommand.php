<?php

namespace Tissou\XdaysaysayBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tissou\XdaysaysayBundle\Entity\IRCServer;
use Tissou\XdaysaysayBundle\Entity\Pack;
use Tissou\XdaysaysayBundle\Entity\Xdcc;
use Tissou\XdaysaysayBundle\Entity\XdccName;
use Zeroem\CurlBundle\Curl\Request;
use \SimpleXMLElement;
use \DateTime;

class UpdateCommand extends ContainerAwareCommand
{
    private $ircServers;
    private $xdccNames;

    protected function configure()
    {
        $this
            ->setName('xdcc:update')
            ->setDescription('Update all xdccs contents');
    }

    private function findXdccName($ircServer, $xdcc)
    {
        /** @type XdccName $xdccName */
        foreach ($this->xdccNames as $xdccName) {
            if ($xdccName->getIrcServer() == $ircServer
                && $xdccName->getXdcc() == $xdcc) {
                return $xdccName;
            }
        }

        return new XdccName();
    }

    private function findIRCServer($host)
    {
        /** @type IRCServer $ircServer */
        foreach ($this->ircServers as $ircServer) {
            if ($ircServer->getHost() == $host) {
                return $ircServer;
            }
        }
        return null;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();
        $xdccs = $manager->getRepository('TissouXdaysaysayBundle:Xdcc')
            ->findAll();

        $this->ircServers = $manager->getRepository('TissouXdaysaysayBundle:IRCServer')
            ->findAll();

        $this->xdccNames = $manager->getRepository('TissouXdaysaysayBundle:XdccName')
            ->findAll();

        /** @type Xdcc $xdcc */
        foreach ($xdccs as $xdcc) {
            $url = ($xdcc->getServer()->getSsl() ? 'https://' : 'http://') . $xdcc->getServer()->getHost() . ':' . $xdcc->getServer()->getHttpPort() . $xdcc->getUrl();
            $request = new Request($url);

            $options = [CURLOPT_RETURNTRANSFER => true];
            if ($xdcc->getServer()->getSsl()) {
                $options[CURLOPT_SSL_CIPHER_LIST] = "ECDHE-ECDSA-AES256-SHA:ECDH-ECDSA-AES256-SHA:ECDHE-ECDSA-AES128-SHA:ECDH-ECDSA-AES128-SHA:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES256-SHA384:ECDH-ECDSA-AES256-GCM-SHA384:ECDH-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES128-SHA256:ECDH-ECDSA-AES128-GCM-SHA256:ECDH-ECDSA-AES128-SHA256";
                $options[CURLOPT_SSL_VERIFYPEER] = false;
            }
            $request->setOptionArray($options);

            $xml = $request->execute();
            $dom = new SimpleXMLElement($xml);

            // Xdcc infos
            $xdcc->setDiskspace($dom->sysinfo->quota->diskspace);
            $xdcc->setTransferedtotal($dom->sysinfo->quota->transferedtotal);
            $xdcc->setTotaluptime($dom->sysinfo->stats->totaluptime);
            $xdcc->setLastupdate(new DateTime("@" . $dom->sysinfo->stats->lastupdate));
            $packs = $xdcc->getPacks();

            // Erase old packs
            /** @type Pack $pack */
            foreach( $packs as $pack)
            {
                $xdcc->removePack($pack);
                $manager->remove($pack);
            }

            $manager->flush();

            // Packs
            foreach ($dom->packlist->pack as $xmlPack) {
                $pack = new Pack();
                $pack->setId((int)$xmlPack->packnr);
                $pack->setName((string) $xmlPack->packname);
                $pack->setSize((string) $xmlPack->packsize);
                $pack->setGets((string) $xmlPack->packgets);
                $pack->setAdddate(new DateTime("@" . $xmlPack->adddate));
                $pack->setMd5sum((string) $xmlPack->md5sum);
                $pack->setCrc32((string) $xmlPack->crc32);
                $pack->setXdcc($xdcc);
                $xdcc->getPacks()->add($pack);
                $manager->persist($pack);

            }

            $manager->persist($xdcc);
            $manager->flush();

            //Xdcc Names

            foreach ($dom->sysinfo->network as $network) {
                $ircServer = $this->findIRCServer($network->servername);
                if($ircServer) {
                    $xdccName = $this->findXdccName( $ircServer, $xdcc);
                    $xdccName->setName($network->currentnick);
                    $xdccName->setXdcc($xdcc);
                    $xdccName->setIrcServer($ircServer);

                    $manager->persist($xdccName);
                }

            }
        }
        $manager->flush();
    }
}