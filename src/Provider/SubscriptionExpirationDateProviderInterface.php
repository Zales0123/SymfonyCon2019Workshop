<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order\OrderItem;

interface SubscriptionExpirationDateProviderInterface
{
    public function fromOrderItem(OrderItem $orderItem): \DateTimeInterface;
}
