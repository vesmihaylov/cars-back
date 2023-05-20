<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DealFeature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DealFeature>
 *
 * @method DealFeature|null find($id, $lockMode = null, $lockVersion = null)
 * @method DealFeature|null findOneBy(array $criteria, array $orderBy = null)
 * @method DealFeature[]    findAll()
 * @method DealFeature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DealFeatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DealFeature::class);
    }

    public function save(DealFeature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DealFeature $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
