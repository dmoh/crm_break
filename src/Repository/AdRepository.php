<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    // /**
    //  * @return Ad[] Returns an array of Ad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    //public function find


    public function findAllArrayAd(){
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
    }


    private function transform(Ad $ad)
    {
        return [
            'id'    => (int) $ad->getId(),
            'title' => (string) $ad->getTitle(),
            'amount' => (int) $ad->getAmount(),
            'tags' => (int) $ad->getTags(),
            //'contacts' => (int) $ad->getContacts()
        ];
    }

    public function transformAll()
    {
        $ads = $this->findAll();
        $adsArray = [];

        foreach ($ads as $ad) {
            $adsArray[] = $this->transform($ad);
        }

        return $adsArray;
    }
    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
