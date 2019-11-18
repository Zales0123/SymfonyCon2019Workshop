<?php

declare(strict_types=1);

namespace App\Notifier;

use App\Entity\Subscription;

interface SubscriptionProlongCustomerNotifierInterface
{
    public function notify(Subscription $subscription): void;
}
