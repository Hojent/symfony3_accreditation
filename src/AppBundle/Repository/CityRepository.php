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

    public function getItemList($cityFilterEntity)
    {
               $query = $this->createQueryBuilder('c')
                   //->select('c')
                   //->from('AppBundle:City','c')
                   ->orderBy('c.name', 'ASC')
               ;
               if ($cityFilterEntity->getRegion()) {
                   $query
                   ->andWhere('c.region =:regionSelected')
                   ->setParameter('regionSelected', $cityFilterEntity->getRegion() );
                }

               //$result = $query->getQuery()->getResult();
               $result = $query->getQuery();

               return $result;

    }

}



