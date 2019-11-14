<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Order\Order;

interface SubscriptionCreatorInterface
{
    public function fromOrder(Order $order): void;
}
