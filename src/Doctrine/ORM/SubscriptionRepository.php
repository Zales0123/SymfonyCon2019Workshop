<?php

declare(strict_types=1);

namespace App\Doctrine\ORM;

use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;

final class SubscriptionRepository extends EntityRepository
{
    public function createByCustomerQueryBuilder(int $customerId): QueryBuilder
    {
        return $this->createQueryBuilder('subscription')
            ->andWhere('subscription.customer = :customerId')
            ->setParameter('customerId', $customerId)
        ;
    }
}
