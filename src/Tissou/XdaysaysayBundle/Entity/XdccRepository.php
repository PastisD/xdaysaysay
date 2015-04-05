<?php

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\EntityRepository;


class XdccRepository extends EntityRepository {
    public function getName( IRCServer $ircServer )
    {
        $manager = $this->getManager();
        return $manager->getRepository('TissouXdaysaysayBundle:XdccName')
            ->getByIRCServer( $ircServer, $this );
    }
}