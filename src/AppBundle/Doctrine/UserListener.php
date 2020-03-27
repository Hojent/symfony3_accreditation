<?php
/**
 * Created by PhpStorm.
 * User: german
 * Date: 23.03.2020
 * Time: 13:40
 */

namespace AppBundle\Doctrine;

use AppBundle\Entity\UserProfile;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class UserListener
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postLoad
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof UserProfile) {
            $this->encryptUserData($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof UserProfile) {
            $this->encryptUserData($entity);
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof UserProfile) {
            $this->decryptUserData($entity);
        }
    }

    private function encryptUserData(UserProfile $user)
    {
        //$plainFamily = $user->getFamily();
        $plainDataborn = $user->getDataborn();
        $plainPassport = $user->getPassportnum();
        $plainPlace = $user->getPlace();

        if ($plainPassport) {
           // $family = openssl_encrypt($plainFamily, 'AES-128-ECB', 'famname');
            $databorn = openssl_encrypt($plainDataborn, 'AES-128-ECB', 'datbork');
            $passport = openssl_encrypt($plainPassport, 'AES-128-ECB', 'passp');
            $place = openssl_encrypt($plainPlace, 'AES-128-ECB', 'place');
            //$user->setFamily($family);
            $user->setDataborn($databorn);
            $user->setPassportnum($passport);
            $user->setPlace($place);
        }
    }

    private function decryptUserData(UserProfile $user)
    {
        $passport = $user->getPassportnum();
        //$family = $user->getFamily();
        $databorn = $user->getDataborn();
        $place = $user->getPlace();
       // $plainFamily = openssl_decrypt($family, 'AES-128-ECB', 'famname');
        $plainDataborn = openssl_decrypt($databorn, 'AES-128-ECB', 'datbork');
        $plainPassport = openssl_decrypt($passport, 'AES-128-ECB', 'passp');
        $plainPlace = openssl_decrypt($place, 'AES-128-ECB', 'place');
        $user->setPassportnum($plainPassport);
       // $user->setFamily($plainFamily);
        $user->setDataborn($plainDataborn);
        $user->setPlace($plainPlace);
    }

}