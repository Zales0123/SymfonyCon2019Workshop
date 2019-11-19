<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\Product;
use App\Entity\Subscription;
use App\Factory\SubscriptionFactoryInterface;
use App\Provider\SubscriptionExpirationTimeProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class SubscriptionCreator
{
    /** @var SubscriptionFactoryInterface */
    private $subscriptionFactory;

    /** @var ObjectManager */
    private $subscriptionManager;

    /** @var SubscriptionExpirationTimeProviderInterface */
    private $subscriptionExpirationTimeProvider;

    public function __construct(
        SubscriptionFactoryInterface $subscriptionFactory,
        ObjectManager $subscriptionManager,
        SubscriptionExpirationTimeProviderInterface $subscriptionExpirationTimeProvider
    ) {
        $this->subscriptionFactory = $subscriptionFactory;
        $this->subscriptionManager = $subscriptionManager;
        $this->subscriptionExpirationTimeProvider = $subscriptionExpirationTimeProvider;
    }

    public function createFromOrder(Order $order): void
    {
        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            /** @var Product $product */
            $product = $item->getVariant()->getProduct();
            if (!$product->isSubscription()) {
                continue;
            }

            $subscription = $this->subscriptionFactory->createWithData(
                $item->getVariant(),
                $order->getCustomer(),
                $this->subscriptionExpirationTimeProvider->fromOrderItem($item)
            );

            $this->subscriptionManager->persist($subscription);
        }

        $this->subscriptionManager->flush();
    }
}
