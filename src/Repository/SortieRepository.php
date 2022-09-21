<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Modele\Filtre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function searchSorties(Filtre $filtre)
    {
        if ($filtre->campus!=null) {
            return $this->createQueryBuilder('Sorties')
                ->andWhere('Sorties.campus = :campus')
                ->andWhere('Sorties.nom = :nom')
                ->andWhere('Sorties.dateHeureDebut >= :dateDebut')
                ->andWhere('Sorties.dateHeureDebut <= :dateFin')
                //->andWhere('Sorties.pasInscrit = :campus')
                //->andWhere('Sorties.passee = :campus')
                ->setParameter('campus', $filtre->campus)
                ->setParameter('nom', $filtre->nom)
                ->setParameter('dateDebut', $filtre->dateDebut);
                //->setParameter('dateFin', $filtre->getDateFin())
                //->setParameter('organisateur', $filtre->getOrganisateur());
                //->setParameter('inscrit', $filtre->getInscrit())
                //->setParameter('pasInscrit', $filtre->getPasInscrit())
                //->setParameter('passees', $filtre->getPasse());
        }else{
            return $this->findAll();
        }
    }




}
