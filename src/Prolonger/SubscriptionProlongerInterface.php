<?php

declare(strict_types=1);

namespace App\Prolonger;

use App\Entity\Subscription;

interface SubscriptionProlongerInterface
{
    public function prolong(Subscription $subscription): void;
}
