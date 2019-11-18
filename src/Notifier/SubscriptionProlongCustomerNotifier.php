<?php

declare(strict_types=1);

namespace App\Notifier;

use App\Entity\Subscription;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class SubscriptionProlongCustomerNotifier implements SubscriptionProlongCustomerNotifierInterface
{
    /** @var SenderInterface */
    private $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function notify(Subscription $subscription): void
    {
        $this->sender->send('subscription_prolonged', [$subscription->getCustomer()->getEmail()], ['subscription' => $subscription]);
    }
}
