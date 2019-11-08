<?php

declare(strict_types=1);

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addSubscriptionsSubmenu(MenuBuilderEvent $event): void
    {
        $salesSubmenu = $event->getMenu()->getChild('sales');

        $salesSubmenu
            ->addChild('subscriptions', ['route' => 'app_admin_subscription_index'])
            ->setLabel('Subscriptions')
            ->setLabelAttribute('icon', 'clock')
        ;
    }
}
