<?php

declare(strict_types=1);

namespace App\Creator;

use Sylius\Component\Core\Model\OrderInterface;

interface SubscriptionCreatorInterface
{
    public function fromOrder(OrderInterface $order): void;
}
