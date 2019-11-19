<?php

declare(strict_types=1);

namespace App\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addSubscriptionSection(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $subMenu = $menu->getChild('sales');

        $subMenu
            ->addChild('subscriptions', [
                'route' => 'app_admin_subscription_index',
            ])->setLabel('app.ui.subscriptions')
            ->setLabelAttribute('icon', 'clock')
        ;
    }
}
