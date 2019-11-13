<?php

declare(strict_types=1);

namespace App\Command;

use App\Creator\RenewalOrderCreatorInterface;
use App\Entity\Subscription;
use App\Renewer\SubscriptionRenewerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RenewSubscriptionsCommand extends Command
{
    /** @var RepositoryInterface */
    private $subscriptionRepository;

    /** @var SubscriptionRenewerInterface */
    private $subscriptionRenewer;

    public function __construct(
        RepositoryInterface $subscriptionRepository,
        SubscriptionRenewerInterface $subscriptionRenewer
    ) {
        parent::__construct('app:renew-subscriptions');

        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionRenewer = $subscriptionRenewer;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Subscription $subscription */
        foreach ($this->subscriptionRepository->findAll() as $subscription) {
            $this->subscriptionRenewer->renew($subscription);
        }
    }
}
