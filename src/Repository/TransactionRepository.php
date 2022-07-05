<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    private $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Transaction::class);
        $this->em = $em;
    }

    public function add(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Transaction[] Returns an array of Transaction objects
    */
   public function findByField($fieldName): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.txnType = :val')
           ->setParameter('val', $fieldName)
           ->orderBy('t.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Transaction[] Returns an array of Transaction objects
    */
   public function getLatestSales(): array
   {
        $txnType = 'sales';
        return $this->createQueryBuilder('t')
           ->andWhere('t.txnType = :transactionType')
           ->setParameter('transactionType', $txnType)
           ->orderBy('t.txnDate', 'DESC')
           ->setMaxResults(5)
           ->getQuery()
           ->getResult()
       ;
   }

   /**
    * @return Transaction[] Returns an array of Transaction objects
    */
    public function getTodaySales(): array
    {
        // $currentDate = new \DateTime();
        $date  = new \DateTimeImmutable();
        $today = $date->format('Y-m-d');
        $txnType = 'sales';

        $queryBuilder = $this->em->createQueryBuilder('t');
        $query = $queryBuilder
            ->select(array('t'))
            ->from('App\Entity\Transaction', 't')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('t.txnType', ':transactionType'),
                    $queryBuilder->expr()->eq('t.txnDate', ':transactionDate')
                )
            )
            ->setParameter('transactionType', $txnType)
            ->setParameter('transactionDate', $today)
            ->orderBy('t.txnDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery();

        return $query->getResult();
       ;
    }

    /**
     * @return Transaction[] Returns an array of Transaction objects
     */
    //  public function getMonthlySales(): array
    //  {
    //      $currentDate = new \DateTime();
    //      $date  = new \DateTimeImmutable();
    //      $today = $date->format('Y');
    //      $txnType = 'sales';

    //     $fields = array(
    //         'MONTH(t.txnDate) as mname, SUM(t.amount) AS total', 
    //         '(CASE WHEN SUM(t.amount) IS NULL THEN 0 ELSE SUM(t.amount) END)'
    //     );
 
    //      $queryBuilder = $this->em->createQueryBuilder('t');
    //      $query = $queryBuilder
    //          ->select($fields)
    //          ->from('App\Entity\Transaction', 't')
    //          ->andWhere('t.txnType = :transactionType')
    //          ->setParameter('transactionType', $txnType)
    //          ->orderBy('t.txnDate', 'ASC')
    //          ->setMaxResults(5)
    //          ->getQuery();
 
    //      return $query->getResult();
    //  }
    
    public function getMonthlyReportRowsbyCompany($company, $year, $state)
    {
        $searchYear = New \DateTimeImmutable("$year-01T-01T00:00:00");
        $fields = array('MONTH(c.month) as mOrder,MONTHNAME(c.month) AS mName', '(CASE WHEN SUM(e.price) IS NULL THEN 0 ELSE SUM(e.price) END)' ,'(CASE WHEN SUM(s.price) IS NULL THEN 0 ELSE SUM(s.price) END)');
        
        $query = $this->createQueryBuilder('c')
            ->set('lc_time_names', 'tr_TR')
            ->select($fields)
            ->leftJoin('App:Sales', 's', 'WITH', 'MONTH(c.month) = MONTH(s.created_at) AND s.Company= :company AND s.state IN (:state) AND YEAR(s.created_at) = YEAR(:searchYear)')
            ->setParameter('company', $company)
            ->setParameter(':searchYear', $searchYear)
            ->leftJoin('App:Expenses', 'e', 'WITH', 'e.sales=s.id')
            ->orderBy('mOrder', 'ASC')
            ->groupBy('c.month');
        
        
        return $query
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Transaction[] Returns an array of Transaction objects
     */
    public function getLatestExpenses(): array
    {
         $txnType = 'expenses';
         return $this->createQueryBuilder('t')
            ->andWhere('t.txnType = :transactionType')
            ->setParameter('transactionType', $txnType)
            ->orderBy('t.txnDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

   /**
    * @return Transaction[] Returns an array of Transaction objects
    */
    public function getTodayExpenses(): array
    {
        // $currentDate = new \DateTime();
        $date  = new \DateTimeImmutable();
        $today = $date->format('Y-m-d');
        $txnType = 'expenses';

        $queryBuilder = $this->em->createQueryBuilder('t');
        $query = $queryBuilder
            ->select(array('t'))
            ->from('App\Entity\Transaction', 't')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('t.txnType', ':transactionType'),
                    $queryBuilder->expr()->eq('t.txnDate', ':transactionDate')
                )
            )
            ->setParameter('transactionType', $txnType)
            ->setParameter('transactionDate', $today)
            ->orderBy('t.txnDate', 'DESC')
            ->setMaxResults(5)
            ->getQuery();

        return $query->getResult();
       ;
    }

    /**
     * @return Transaction[] Returns an array of Transaction objects
     */
     public function getMothlyExpenses(): array
     {
         // $currentDate = new \DateTime();
         $date  = new \DateTimeImmutable();
         $today = $date->format('Y-m-d');
         $txnType = 'expenses';
 
         $queryBuilder = $this->em->createQueryBuilder('t');
         $query = $queryBuilder
             ->select(array('t'))
             ->from('App\Entity\Transaction', 't')
             ->where(
                 $queryBuilder->expr()->andX(
                     $queryBuilder->expr()->eq('t.txnType', ':transactionType'),
                     $queryBuilder->expr()->eq('t.txnDate', ':transactionDate')
                 )
             )
             ->setParameter('transactionType', $txnType)
             ->setParameter('transactionDate', $today)
             ->orderBy('t.txnDate', 'DESC')
             ->setMaxResults(5)
             ->getQuery();
 
         return $query->getResult();
        ;
     }

   /**
    * @return Transaction[] Returns an array of Transaction objects
    */
   public function getSales($txnType): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.txnType = :transactionType')
           ->setParameter('transactionType', $txnType)
           ->orderBy('t.txnDate', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Transaction
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
