<?php

namespace App\Repository;

use App\Entity\FavouriteDeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavouriteDeal>
 *
 * @method FavouriteDeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteDeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteDeal[]    findAll()
 * @method FavouriteDeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteDealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteDeal::class);
    }

    public function save(FavouriteDeal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FavouriteDeal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
