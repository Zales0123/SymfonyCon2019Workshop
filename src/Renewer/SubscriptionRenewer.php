<?php

declare(strict_types=1);

namespace App\Renewer;

use App\Creator\RenewalOrderCreatorInterface;
use App\Entity\Subscription;
use App\Notifier\SubscriptionProlongCustomerNotifierInterface;
use App\Prolonger\SubscriptionProlongerInterface;

final class SubscriptionRenewer implements SubscriptionRenewerInterface
{
    /** @var RenewalOrderCreatorInterface */
    private $renewalOrderCreator;

    /** @var SubscriptionProlongerInterface */
    private $subscriptionProlonger;

    /** @var SubscriptionProlongCustomerNotifierInterface */
    private $subscriptionProlongCustomerNotifier;

    public function __construct(
        RenewalOrderCreatorInterface $renewalOrderCreator,
        SubscriptionProlongerInterface $subscriptionProlonger,
        SubscriptionProlongCustomerNotifierInterface $subscriptionProlongCustomerNotifier
    ) {
        $this->renewalOrderCreator = $renewalOrderCreator;
        $this->subscriptionProlonger = $subscriptionProlonger;
        $this->subscriptionProlongCustomerNotifier = $subscriptionProlongCustomerNotifier;
    }

    public function renew(Subscription $subscription): void
    {
        if ($subscription->getExpirationTime() > (new \DateTime('-1 day'))) {
            return;
        }

        $this->renewalOrderCreator->fromSubscription($subscription);
        $this->subscriptionProlonger->prolong($subscription);
        $this->subscriptionProlongCustomerNotifier->notify($subscription);
    }
}
