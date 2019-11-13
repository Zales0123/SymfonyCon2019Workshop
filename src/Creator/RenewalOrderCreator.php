<?php

declare(strict_types=1);

namespace App\Creator;

use App\Entity\Order\OrderItem;
use App\Entity\Subscription;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Factory\FactoryInterface as StateMachineFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Webmozart\Assert\Assert;

final class RenewalOrderCreator implements RenewalOrderCreatorInterface
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ObjectManager */
    private $orderManager;

    /** @var FactoryInterface */
    private $orderFactory;

    /** @var FactoryInterface */
    private $orderItemFactory;

    /** @var OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var StateMachineFactoryInterface */
    private $stateMachineFactory;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ObjectManager $orderManager,
        FactoryInterface $orderFactory,
        FactoryInterface $orderItemFactory,
        OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        StateMachineFactoryInterface $stateMachineFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderManager = $orderManager;
        $this->orderFactory = $orderFactory;
        $this->orderItemFactory = $orderItemFactory;
        $this->orderItemQuantityModifier = $orderItemQuantityModifier;
        $this->stateMachineFactory = $stateMachineFactory;
    }

    public function fromSubscription(Subscription $subscription): void
    {
        /** @var OrderInterface $order */
        $order = $this->orderRepository->find($subscription->getOriginOrderId());
        Assert::notNull($order);

        /** @var OrderInterface $renewalOrder */
        $renewalOrder = $this->orderFactory->createNew();
        $renewalOrder->setChannel($order->getChannel());
        $renewalOrder->setLocaleCode($order->getLocaleCode());
        $renewalOrder->setCustomer($order->getCustomer());
        $renewalOrder->setCurrencyCode($order->getCurrencyCode());
        $renewalOrder->setShippingAddress(clone $order->getShippingAddress());
        $renewalOrder->setBillingAddress(clone $order->getBillingAddress());

        /** @var OrderItem $orderItem */
        foreach ($order->getItems() as $orderItem) {
            /** @var OrderItem $renewalItem */
            $renewalItem = $this->orderItemFactory->createNew();
            $renewalItem->setVariant($orderItem->getVariant());
            $renewalItem->setSubscriptionPeriod($orderItem->getSubscriptionPeriod());
            $this->orderItemQuantityModifier->modify($renewalItem, $orderItem->getQuantity());

            $renewalOrder->addItem($renewalItem);
        }

        $this->orderRepository->add($renewalOrder);

        $this->processOrder($renewalOrder);

        $this->orderManager->flush();
    }

    private function processOrder(OrderInterface $order): void
    {
        $orderCheckoutStateMachine = $this->stateMachineFactory->get($order, OrderCheckoutTransitions::GRAPH);
        $orderCheckoutStateMachine->apply(OrderCheckoutTransitions::TRANSITION_ADDRESS);
        $orderCheckoutStateMachine->apply(OrderCheckoutTransitions::TRANSITION_SKIP_SHIPPING);
        $orderCheckoutStateMachine->apply(OrderCheckoutTransitions::TRANSITION_SELECT_PAYMENT);
        $orderCheckoutStateMachine->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);
    }
}
