<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\Product;
use App\Entity\Subscription;
use App\Provider\SubscriptionExpirationDateProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;

final class SubscriptionCreator implements SubscriptionCreatorInterface
{
    /** @var ObjectManager */
    private $subscriptionManager;

    /** @var SubscriptionExpirationDateProviderInterface */
    private $subscriptionExpirationDateProvider;

    public function __construct(
        ObjectManager $subscriptionManager,
        SubscriptionExpirationDateProviderInterface $subscriptionExpirationDateProvider
    ) {
        $this->subscriptionManager = $subscriptionManager;
        $this->subscriptionExpirationDateProvider = $subscriptionExpirationDateProvider;
    }

    public function fromOrder(Order $order): void
    {
        if ($order->getSubscription() !== null) {
            return;
        }

        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getType() !== Product::TYPE_SUBSCRIPTION) {
                continue;
            }

            $subscription = new Subscription(
                $item->getVariant(),
                $order->getCustomer(),
                $this->subscriptionExpirationDateProvider->fromOrderItem($item),
                $item->getSubscriptionPeriod(),
                $order->getId()
            );

            $this->subscriptionManager->persist($subscription);
        }

        $this->subscriptionManager->flush();
    }
}
