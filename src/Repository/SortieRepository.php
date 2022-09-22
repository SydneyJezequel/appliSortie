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

    public function searchSorties(Filtre $filtre)
    {
            $qb= $this->createQueryBuilder('Sorties');
                if ($filtre->campus!=null) {
                    $qb->andWhere('Sorties.campus = :campus')
                       ->setParameter('campus', $filtre->campus);
                }
                if ($filtre->nom!=null) {
                    $qb->andWhere('Sorties.nom = :nom')
                        ->setParameter('nom', $filtre->nom);
                }
                if ($filtre->dateDebut!=null) {
                    $qb->andWhere('Sorties.dateHeureDebut >= :dateDebut')
                        ->setParameter('dateDebut', $filtre->dateDebut);
                }
                if ($filtre->dateFin!=null) {
                    $qb->andWhere('Sorties.dateHeureDebut <= :dateFin')
                        ->setParameter('dateFin', $filtre->dateFin);
                }
                if ($filtre->organisateur) {
                    $qb->andWhere('Sorties.organisateur = :organisateur')
                    ->setParameter('organisateur', $filtre->id);
                }
//                if ($filtre->inscrit) {
//
//                    $qb->join('Participants.inscrits', 'i')
////                        ->addSelect('i')
////                        ->andWhere('Sorties.inscrits = :inscrit')
////                        ->setParameter('inscrit', $filtre->id);
////
////                    $query->select ('c');
////                    $query->from(MyBundle:Company, 'c');
////                    $query->leftJoin('c.ChildrenCompany','j');
////                    $query->where('j.id = :subCompanyId');
////                    $query->setParameter("subCompanyId", 5);
//                }

                if ($filtre->inscrit) { $qb->andWhere(":isInscrit MEMBER OF Sorties.inscrits")->setParameter("isInscrit", $filtre->id); }

                if (!$filtre->inscrit) { $qb->andWhere(":isNotInscrit NOT MEMBER OF Sorties.inscrits")->setParameter("isNotInscrit", $filtre->id); }

                if ($filtre->passee) {
                    $qb->andWhere('Sorties.dateHeureDebut <= :dateJour')
                        ->setParameter('dateJour', date('d-m-y'));
                }
                return $qb->getQuery()->getResult();
    }



}
