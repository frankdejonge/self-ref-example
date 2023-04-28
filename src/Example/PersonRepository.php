<?php
declare(strict_types=1);

namespace App\Example;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function dd;
use function dump;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[] findAll()
 * @method Person[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findConnectedToAndExcluding(array $fromPeople, $excludeThesePeople)
    {
        return $this->createQueryBuilder('person')
            ->select('p1')
            ->from(Person::class, 'p1')
            ->where('p1.id NOT IN (:excluded)')
            ->innerJoin('p1.friends', 'p2')
            ->andWhere('p2.id IN (:included)')
            ->setParameter('included', $fromPeople)
            ->setParameter('excluded', $excludeThesePeople)
            ->getQuery()
            ->getResult();
    }

    public function store(Person $person): void
    {
        $this->_em->persist($person);
        $this->_em->flush();
    }
}
