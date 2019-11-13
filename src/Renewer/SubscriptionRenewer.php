<?php

declare(strict_types=1);

namespace App\Renewer;

use App\Creator\RenewalOrderCreatorInterface;
use App\Entity\Subscription;

final class SubscriptionRenewer implements SubscriptionRenewerInterface
{
    /** @var RenewalOrderCreatorInterface */
    private $renewalOrderCreator;

    public function __construct(RenewalOrderCreatorInterface $renewalOrderCreator)
    {
        $this->renewalOrderCreator = $renewalOrderCreator;
    }

    public function renew(Subscription $subscription): void
    {
        if ($subscription->getExpirationTime() > (new \DateTime('-1 day'))) {
            return;
        }

        $this->renewalOrderCreator->fromSubscription($subscription);
    }
}
