<?php

namespace App\Repository;

use App\Entity\Pointages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pointages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointages[]    findAll()
 * @method Pointages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointages::class);
    }

    public function findPointersDistinctByChantier()
    {
        $qb = $this->createQueryBuilder('p');
        $chantiers = $qb
                    ->select('c.id', $qb->expr()->countDistinct('p.userId'))
                    ->join('p.chantierId', 'c')
                    ->groupBy('c.id')
                    ->getQuery()
                    ->getResult()
                    ;
        foreach ($chantiers as $chantier) {
            $data[$chantier['id']] = $chantier[1];
        }

        return $data;
    }

    public function findDureeCumuleeByChantier()
    {
        $sql = "select c.id as id, 
                       SEC_TO_TIME( SUM( TIME_TO_SEC( duree_pointage ) ) ) as duree
                from pointages as p
                LEFT JOIN chantiers as c
                    ON c.id = p.chantier_id
                GROUP BY c.id";
        $chantiers = $this->_em->getConnection()
                            ->executeQuery($sql)
                            ->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($chantiers as $chantier) {
            $data[$chantier['id']] = $chantier['duree'];
        }

        return $data;
    }

}
