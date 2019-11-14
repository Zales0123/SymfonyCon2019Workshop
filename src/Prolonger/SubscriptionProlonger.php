<?php

declare(strict_types=1);

namespace App\Prolonger;

use App\Entity\Subscription;
use App\Model\SubscriptionPeriods;
use Doctrine\Common\Persistence\ObjectManager;

final class SubscriptionProlonger implements SubscriptionProlongerInterface
{
    /** @var ObjectManager */
    private $subscriptionManager;

    public function __construct(ObjectManager $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;
    }

    public function prolong(Subscription $subscription): void
    {
        /** @var \DateTime $currentExpirationTime */
        $currentExpirationTime = clone $subscription->getExpirationTime();

        $subscription->setExpirationTime($currentExpirationTime->modify(
            ($subscription->getPeriod() === SubscriptionPeriods::YEAR) ? '+1 year' : '+1 month'
        ));

        $this->subscriptionManager->flush();
    }
}
