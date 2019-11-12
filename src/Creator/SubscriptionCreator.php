<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Order\OrderItem;
use App\Entity\Product\Product;
use App\Entity\Subscription;
use App\Provider\SubscriptionExpirationDateProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Core\Model\OrderInterface;

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

    public function fromOrder(OrderInterface $order): void
    {
        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getType() !== Product::TYPE_SUBSCRIPTION) {
                continue;
            }

            $subscription = new Subscription(
                $item->getProductName(),
                $order->getCustomer(),
                $this->subscriptionExpirationDateProvider->fromOrderItem($item)
            );

            $this->subscriptionManager->persist($subscription);
        }

        $this->subscriptionManager->flush();
    }
}
