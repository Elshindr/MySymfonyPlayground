<?php
namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visite[]    findAll()
 * @method Visite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    /**
     * Retourne toutes les visites existantes triées selon un champ
     * @param type $champ
     * @param type $order
     * @return array
     */
    public function findAllOrderBy($champ, $order): array{
        return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, $order)
                ->getQuery()
                ->getResult();
    }
    
    /**
     * Get tout les records dont le champ égal à la valeur passée
     * en parametre, ou tous si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur): array{
        if($valeur == ""){
            return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, 'ASC')
                ->getQuery()
                ->getResult();
    }else{
        return $this->createQueryBuilder('v')
                ->where('v.'.$champ.'=:valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();
    }
        }
        
        /**
         * Recuperer les deux derniere visites
         * @return Visite[]
         */
   public function findByLastVisite():array{
       return $this->createQueryBuilder('v')
               ->orderBy('v.datecreation','DESC')
               ->setMaxResults(2)
               ->getQuery()
               ->getResult();     
               
   }
}
