<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Order\OrderItem;

final class SubscriptionExpirationDateProvider implements SubscriptionExpirationDateProviderInterface
{
    public function fromOrderItem(OrderItem $orderItem): \DateTimeInterface
    {
        $selectedPeriod = $orderItem->getSubscriptionPeriod();

        if ($selectedPeriod === 'month') {
            return new \DateTime('+1 month');
        }

        if ($selectedPeriod === 'year') {
            return new \DateTime('+1 year');
        }

        throw new \InvalidArgumentException(sprintf('Subscription period "%s" is invalid', $selectedPeriod));
    }
}
