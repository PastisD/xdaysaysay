<?php

namespace Xdaysaysay\CoreBundle\Entity\Repository;

use Xdaysaysay\CoreBundle\Entity\Xdcc;

/**
 * SerieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class XdccRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param array      $searchTerms
     * @param array      $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param bool|false $count
     * @param array      $columnSearch
     *
     * @return int|Xdcc[]
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLike($searchTerms = [], $orderBy = [], $limit = null, $offset = null, $count = false, $columnSearch = array())
    {
        $array = [
            'id'          => 's.id',
            'chan_name'   => 't.chan_name',
            'server_name' => 's.name',
            'bot_name'    => 't.bot_name',
            'packs'       => 'nb_packs',
            'visible'     => 'x.visible',
        ];

        $nbPackQb = $this->_em->createQueryBuilder();
        $nbPackQb->select('COUNT(p.id)');
        $nbPackQb->from('XdaysaysayCoreBundle:Pack', 'p');
        $nbPackQb->where($nbPackQb->expr()->eq('p.xdcc', 'x'));

        $qb = $this->createQueryBuilder('x');
        $qb->addSelect('t');
        $qb->addSelect('s');
        $qb->addSelect('(' . $nbPackQb->getDQL() . ') AS HIDDEN nb_packs');
        $qb->leftJoin('x.teams', 't');
        $qb->leftJoin('x.server', 's');

        if (is_array($searchTerms)) {
            foreach ($searchTerms as $term) {
                if (!empty($term)) {
                    $qb->andWhere($qb->expr()->orX(
                        $qb->expr()->like('x.id', $qb->expr()->literal('%'.$term.'%')),
                        $qb->expr()->like('s.name', $qb->expr()->literal('%'.$term.'%')),
                        $qb->expr()->like('t.chan_name', $qb->expr()->literal('%'.$term.'%')),
                        $qb->expr()->like('t.bot_name', $qb->expr()->literal('%'.$term.'%'))
                    ));
                }
            }
        }

        $qb->orderBy($array[$orderBy[0]], ucwords($orderBy[1]));
        if (!$count) {
            $qb->setFirstResult($offset);
            $qb->setMaxResults($limit);
            return $qb->getQuery()->getResult();
        } else {
            $qb->select($qb->expr()->countDistinct('x.id'));
            $qb->addSelect('(' . $nbPackQb->getDQL() . ') AS HIDDEN nb_packs');

            $result = $qb->getQuery()->getScalarResult();
            return $result[0];
        }
    }

    public function countAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('count(x.id)')
            ->from('XdaysaysayCoreBundle:Xdcc', 'x');

        return $qb->getQuery()->getSingleScalarResult();
    }
}
