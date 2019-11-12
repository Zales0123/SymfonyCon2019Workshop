<?php

declare(strict_types=1);

namespace App\Doctrine\ORM;

use App\Entity\Subscription;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

final class SubscriptionRepository extends EntityRepository
{
    public function createByCustomerQueryBuilder(int $customerId): QueryBuilder
    {
        return $this->createQueryBuilder('subscription')
            ->andWhere('subscription.customer = :customerId')
            ->andWhere('subscription.state = :state')
            ->setParameter('customerId', $customerId)
            ->setParameter('state', Subscription::STATE_ACTIVE)
        ;
    }
}
