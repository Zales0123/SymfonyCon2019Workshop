<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order\OrderItem;

final class DummySubscriptionExpirationTimeProvider implements SubscriptionExpirationTimeProviderInterface
{
    public function fromOrderItem(OrderItem $orderItem): \DateTimeInterface
    {
        return new \DateTime('+1 month');
    }
}
