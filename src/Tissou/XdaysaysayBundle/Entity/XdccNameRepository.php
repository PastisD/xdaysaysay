<?php

namespace Tissou\XdaysaysayBundle\Entity;

use Doctrine\ORM\EntityRepository;


class XdccNameRepository extends EntityRepository {
    public function getByIRCServer( IRCServer $ircServer, Xdcc $xdcc )
    {
        $qb = $this->createQueryBuilder( 'xm' );
        $qb->where('xm.ircServer = :ircServer');
        $qb->where('xm.xdcc = :xdcc');
        $qb->setParameter('userType', $ircServer);
        $qb->setParameter('xdcc', $xdcc);

        $query = $qb->getQuery();

        return $query;
    }
}