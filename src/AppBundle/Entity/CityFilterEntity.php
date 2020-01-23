<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Region;

// City фильтрует по регионам

class CityFilterEntity
{


    /**
     * @var Region
     *
     */
    protected $region;    //to gard form external influence. For child only.

    public function getRegion(): ? Region
    {
        return $this->region;
    }

    public function setRegion(Region $region = null) :void
    {
        $this->region = $region;
    }


}



