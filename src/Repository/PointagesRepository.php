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
        $sql = "SELECT c.id as id, 
                       SEC_TO_TIME( SUM( TIME_TO_SEC( duree_pointage ) ) ) as duree
                FROM pointages as p
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

    public function findUserByDateAndChantier($user, $chantier, $date)
    {
        $sql = "SELECT id
                FROM pointages as p
                WHERE 1
                    AND user_id = :user
                    AND chantier_id = :chantier
                    AND date_pointage = :date
                ";

        $req = $this->_em->getConnection()->prepare($sql);
        $req->execute([
             'user' => $user
            ,'chantier' => $chantier
            ,'date' => $date
        ]);

        return $req->rowCount();
    }

    public function findDureeByUserAndSemaine($user, $date, $duree) {

        $sql = "SELECT SUM( TIME_TO_SEC( duree_pointage ) ) + TIME_TO_SEC(:duree) as duree_sec
                FROM pointages as p
                WHERE 1
                    AND user_id = :user
                    AND WEEK(date_pointage) = WEEK(:date)
                ";

        $req = $this->_em->getConnection()->prepare($sql);
        $req->execute([
             'user' => $user
            ,'date' => $date
            ,'duree' => $duree
        ]);

        $seconds = $req->fetchOne();

        return $seconds > 126000; //35H

    }

}
