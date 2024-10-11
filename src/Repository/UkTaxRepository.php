<?php

namespace App\Repository;

use App\Entity\UkTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;

/**
 * @extends ServiceEntityRepository<UkTax>
 */
class UkTaxRepository extends ServiceEntityRepository
{
    public function __construct(
        readonly ManagerRegistry $registry,
        private readonly DecimalMoneyFormatter $moneyFormatter
    )
    {
        parent::__construct($registry, UkTax::class);
    }

    /**
     * @return UkTax[] Returns an array of UkTax objects
     */
    public function findApplicableTaxBrackets(Money $salary): array
    {
        $value = (float)$this->moneyFormatter->format($salary);

        return $this->createQueryBuilder('u')
            ->andWhere('u.min <= :val')
            ->setParameter('val', $value)
            ->orderBy('u.min', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
