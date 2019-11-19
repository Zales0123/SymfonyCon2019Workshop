<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductVariant;
use App\Entity\Subscription;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class SubscriptionFactory implements SubscriptionFactoryInterface
{
    /** @var FactoryInterface */
    private $baseFactory;

    public function __construct(FactoryInterface $baseFactory)
    {
        $this->baseFactory = $baseFactory;
    }

    public function createNew()
    {
        return $this->baseFactory->createNew();
    }

    public function createWithData(
        ProductVariant $productVariant,
        Customer $customer,
        \DateTimeInterface $expirationTime
    ): Subscription {
        /** @var Subscription $subscription */
        $subscription = $this->baseFactory->createNew();
        $subscription->setProductVariant($productVariant);
        $subscription->setCustomer($customer);
        $subscription->setExpirationTime($expirationTime);

        return $subscription;
    }
}
