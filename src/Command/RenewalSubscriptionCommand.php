<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Subscription;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RenewalSubscriptionCommand extends Command
{
    /**
     * @var RepositoryInterface
     */
    private $subscriptionRepository;
    /**
     * @var FactoryInterface
     */
    private $orderFactory;
    /**
     * @var CartItemFactoryInterface
     */
    private $cartItemFactory;
    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;
    /**
     * @var OrderItemQuantityModifierInterface
     */
    private $itemQuantityModifier;
    /**
     * @var \SM\Factory\FactoryInterface
     */
    private $stateMachineFactory;
    /**
     * @var ObjectManager
     */
    private $orderManager;

    public function __construct(
        RepositoryInterface $subscriptionRepository,
        FactoryInterface $orderFactory,
        CartItemFactoryInterface $cartItemFactory,
        ChannelRepositoryInterface $channelRepository,
        OrderItemQuantityModifierInterface $itemQuantityModifier,
        \SM\Factory\FactoryInterface $stateMachineFactory,
        ObjectManager $orderManager
    ) {
        parent::__construct('app:renew-subscription');
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderFactory = $orderFactory;
        $this->cartItemFactory = $cartItemFactory;
        $this->channelRepository = $channelRepository;
        $this->itemQuantityModifier = $itemQuantityModifier;
        $this->stateMachineFactory = $stateMachineFactory;
        $this->orderManager = $orderManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $subscriptions = $this->subscriptionRepository->findBy(['status' => 'active']);

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription) {
            /** @var Order $order */
            $order = $this->orderFactory->createNew();

            $order->setCustomer($subscription->getCustomer());
            $order->setCurrencyCode('USD');
            $order->setLocaleCode('en_US');
            $order->setChannel($this->channelRepository->findOneBy([]));

            /** @var OrderItem $item */
            $item = $this->cartItemFactory->createNew();
            $item->setVariant($subscription->getProductVariant());
            $this->itemQuantityModifier->modify($item, 1);

            $order->addItem($item);

            $stateMachine = $this->stateMachineFactory->get($order, OrderCheckoutTransitions::GRAPH);

            $stateMachine->apply('renew');
            $stateMachine->apply(OrderCheckoutTransitions::TRANSITION_COMPLETE);

            $this->orderManager->persist($order);
        }

        $this->orderManager->flush();
    }
}
