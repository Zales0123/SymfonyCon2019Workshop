<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Subscription;

interface RenewalOrderCreatorInterface
{
    public function fromSubscription(Subscription $subscription): void;
}
