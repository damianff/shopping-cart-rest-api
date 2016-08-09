<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function createFindAllQuery()
    {
        return $this->_em->createQuery(
            "
            SELECT i
            FROM AppBundle:Item i
            "
        );
    }


    public function createFindOneByIdQuery($id)
    {
        $query = $this->_em->createQuery(
            "
            SELECT i
            FROM AppBundle:Item i
            WHERE i.id = :id
            "
        );

        $query->setParameter('id', $id);

        return $query;
    }
}