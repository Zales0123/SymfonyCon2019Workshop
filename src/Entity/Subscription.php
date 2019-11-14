<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Product\ProductVariant;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_subscription")
 */
class Subscription implements ResourceInterface
{
    public const STATE_ACTIVE = 'active';
    public const STATE_EXPIRED = 'expired';
    public const STATE_CANCELLED = 'cancelled';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ProductVariant
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\ProductVariant")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $productVariant;

    /**
     * @var CustomerInterface
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer", inversedBy="subscriptions")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime", name="expiration_time")
     */
    private $expirationTime;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="period")
     */
    private $period;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $state = self::STATE_ACTIVE;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $originOrderId;

    public function __construct(
        ProductVariant $productVariant,
        CustomerInterface $customer,
        \DateTimeInterface $expirationTime,
        string $period,
        int $originOrderId
    ) {
        $this->productVariant = $productVariant;
        $this->customer = $customer;
        $this->expirationTime = $expirationTime;
        $this->period = $period;
        $this->originOrderId = $originOrderId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductVariant(): ProductVariant
    {
        return $this->productVariant;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getExpirationTime(): \DateTimeInterface
    {
        return $this->expirationTime;
    }

    public function setExpirationTime(\DateTimeInterface $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function getOriginOrderId(): int
    {
        return $this->originOrderId;
    }
}
