<?php

declare(strict_types=1);

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AccountMenuListener
{
    public function addSubscriptionsSubmenu(MenuBuilderEvent $event): void
    {
        $accountMenu = $event->getMenu();

        $accountMenu
            ->addChild('subscriptions', ['route' => 'app_shop_account_subscription_index'])
            ->setLabel('app.ui.subscriptions')
            ->setLabelAttribute('icon', 'clock')
        ;
    }
}
