<?php

namespace App\Repository;

use App\Entity\Chantiers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chantiers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chantiers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chantiers[]    findAll()
 * @method Chantiers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChantiersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chantiers::class);
    }
}
