<?php
/**
 * Created by PhpStorm.
 * User: guest
 * Date: 26.08.19
 * Time: 16:13
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    //custom query to load user. On default method - e-mail login is allowed only
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult(); //Get exactly one result or null.
    }

    //связь пользователя с профайлом для вывода в общем списке (юзер+профайл)
    public function loadUserByUserprofile($userprofile)
    {
        return $this->createQueryBuilder('u')
            ->where('u.userprofile = :userprofile')
            ->setParameter('userprofile', $userprofile)
            ->getQuery()
            ->getOneOrNullResult(); //Get exactly one result or null.
    }


}