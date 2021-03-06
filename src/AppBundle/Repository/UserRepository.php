<?php

namespace AppBundle\Repository;


/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
	public function getActiveUsers(){

		$users = $this->createQueryBuilder('u')
                    ->select('u.id, u.firstname, u.lastname, u.zipcode, u.phone, c.name')
                    ->innerJoin('u.company', 'c')
                    ->where('u.active = 1')
                    ->getQuery()
                    ->getResult(); 
        return $users;
	}
}
