<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductVariant;
use App\Entity\Subscription;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface SubscriptionFactoryInterface extends FactoryInterface
{
    public function createWithData(
        ProductVariant $productVariant,
        Customer $customer,
        \DateTimeInterface $expirationTime
    ): Subscription;
}
