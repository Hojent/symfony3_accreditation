<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CityFilterEntity;
use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 */
class CityRepository extends EntityRepository
{

    /**
     * @param CityFilterEntity $cityFilterEntity
     * @return array
     *
     */

    public function getItemList(CityFilterEntity $cityFilterEntity)
    {
               $query = $this->createQueryBuilder('cities')
                   ->select('c')
                   ->from('AppBundle:City','c')
                   ->orderBy('c.name', 'ASC')
               ;
               if ($cityFilterEntity->getRegion()) {
                   $query
                   ->andWhere('c.region =:regionSelected')
                   ->setParameter('regionSelected', $cityFilterEntity->getRegion() );
                }

               $result =$query->getQuery()->getResult();

               return $result;

    }

}



