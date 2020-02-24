<?php

namespace GProduitBundle\Repository;
use Doctrine\ORM\EntityManager;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function RolePart($role)
    {
        $role='ROLE_PART';
        $query=$this->getEntityManager()
            ->createQuery(
                'SELECT u 
                FROM UserBundle:User u 
                WHERE u.roles LIKE :role'
            )
            ->setParameter('role', '%"ROLE_PART"%'
            );
        return $query->getResult();
    }
}