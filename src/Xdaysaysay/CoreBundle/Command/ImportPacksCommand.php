<?php

namespace Xdaysaysay\CoreBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use Sabre\Xml\Service;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Xdaysaysay\CoreBundle\Entity\Pack;
use Xdaysaysay\CoreBundle\Entity\Xdcc;
use Xdaysaysay\CoreBundle\Entity\XdccName;
use Xdaysaysay\CoreBundle\XmlMapping\Iroffer;

class ImportPacksCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('xdaysaysay:import:packs')
            ->setDescription('Import packs for registered xdccs');
    }

    /**
     * @inheritdoc
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     * @throws \LogicException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Sabre\Xml\ParseException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $xdccs = $this->getContainer()->get('doctrine')->getRepository('XdaysaysayCoreBundle:Xdcc')->findAll();

        $progress = new ProgressBar($output, count($xdccs));
        $progress->start();

        foreach ($xdccs as $xdcc) {
            if ($xdcc->getVisible()) {
                $this->updatePacks($xdcc);
            }
            $progress->advance();
        }

        $progress->finish();
    }

    /**
     * Update packs for a xdcc
     *
     * @param Xdcc $xdcc
     *
     * @throws \RuntimeException
     * @throws \Sabre\Xml\ParseException
     * @throws \LogicException
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    private function updatePacks(Xdcc $xdcc)
    {
        $uri = $xdcc->getServer()->getFullUri().$xdcc->getUrl();

        $options = [];
        if ($xdcc->getServer()->getSsl()) {
            $options['curl.options'] = [
                'CURLOPT_SSL_CIPHER_LIST' => 'ECDHE-ECDSA-AES256-SHA:ECDH-ECDSA-AES256-SHA:ECDHE-ECDSA-AES128-SHA:ECDH-ECDSA-AES128-SHA:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES256-SHA384:ECDH-ECDSA-AES256-GCM-SHA384:ECDH-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES128-SHA256:ECDH-ECDSA-AES128-GCM-SHA256:ECDH-ECDSA-AES128-SHA256',
                'CURLOPT_SSL_VERIFYPEER'  => false,
            ];
        }

        $client = new Client();
        $reponse = $client->get($uri, $options);
        $service = new Service();
        $service->elementMap = [
            '{}iroffer'   => 'Xdaysaysay\CoreBundle\XmlMapping\Iroffer',
            '{}packlist'  => 'Xdaysaysay\CoreBundle\XmlMapping\Packs',
            '{}pack'      => 'Xdaysaysay\CoreBundle\XmlMapping\Pack',
            '{}network'   => 'Xdaysaysay\CoreBundle\XmlMapping\Network',
            '{}sysinfo'   => 'Xdaysaysay\CoreBundle\XmlMapping\Sysinfo',
            '{}mainqueue' => 'Xdaysaysay\CoreBundle\XmlMapping\Mainqueue',
            '{}slots'     => 'Xdaysaysay\CoreBundle\XmlMapping\Slots',
            '{}idlequeue' => 'Xdaysaysay\CoreBundle\XmlMapping\Idlequeue',
            '{}bandwidth' => 'Xdaysaysay\CoreBundle\XmlMapping\Bandwidth',
            '{}quota'     => 'Xdaysaysay\CoreBundle\XmlMapping\Quota',
            '{}limits'    => 'Xdaysaysay\CoreBundle\XmlMapping\Limits',
            '{}stats'     => 'Xdaysaysay\CoreBundle\XmlMapping\Stats',
        ];

        /** @var Iroffer $iroffer */
        $iroffer = $service->parse($reponse->getBody()->getContents());

        foreach($xdcc->getXdccnames() as $xdccName) {
            $xdcc->removeXdccname($xdccName);
        }
        foreach($xdcc->getPacks() as $pack) {
            $xdcc->removePack($pack);
        }

        $this->getContainer()->get('doctrine')->getManager()->persist($xdcc);
        $this->getContainer()->get('doctrine')->getManager()->flush();

        foreach ($iroffer->packlist->packs as $pack) {
            $addDate = new \DateTime();
            $addDate->setTimestamp($pack->adddate);

            $xdccPack = new Pack();
            $xdccPack->setId($pack->packnr);
            $xdccPack->setName($pack->packname);
            $xdccPack->setSize($pack->packbytes);
            $xdccPack->setGets($pack->packgets);
            $xdccPack->setAdddate($addDate);
            $xdccPack->setMd5sum($pack->md5sum);
            $xdccPack->setCrc32($pack->crc32);
            $xdccPack->setXdcc($xdcc);
            $xdcc->addPack($xdccPack);
        }

        foreach ($iroffer->sysinfo->networks as $network) {
            $ircServer = $this->getContainer()->get('doctrine')->getRepository('XdaysaysayCoreBundle:IRCServer')->findOneByHost($network->servername);
            if($ircServer) {
                $xdccName = new XdccName();
                $xdccName->setXdcc($xdcc);
                $xdccName->setName($network->currentnick);
                $xdccName->setIrcServer($ircServer);
            }
        }

        $lastUpdate = new \DateTime();
        $lastUpdate->setTimestamp($iroffer->sysinfo->stats->lastupdate);
        $xdcc->setLastupdate($lastUpdate);
        $xdcc->setTotaluptime($iroffer->sysinfo->stats->totaluptime);
        $xdcc->setDiskspace($iroffer->sysinfo->quota->diskspace);

        $this->getContainer()->get('doctrine')->getManager()->persist($xdcc);
        $this->getContainer()->get('doctrine')->getManager()->flush();
    }
}