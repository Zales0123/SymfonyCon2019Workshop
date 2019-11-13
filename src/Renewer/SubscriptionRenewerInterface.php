<?php

declare(strict_types=1);

namespace App\Renewer;

use App\Entity\Subscription;

interface SubscriptionRenewerInterface
{
    public function renew(Subscription $subscription): void;
}
