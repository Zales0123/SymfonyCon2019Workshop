<?php

declare(strict_types=1);

namespace App\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order_item")
 */
class OrderItem extends BaseOrderItem
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $subscriptionPeriod;

    public function getSubscriptionPeriod(): ?string
    {
        return $this->subscriptionPeriod;
    }

    public function setSubscriptionPeriod(?string $subscriptionPeriod): void
    {
        $this->subscriptionPeriod = $subscriptionPeriod;
    }
}
