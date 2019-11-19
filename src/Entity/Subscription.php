<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductVariant;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_subscription")
 */
class Subscription implements ResourceInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $status = 'active';

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="datetime", name="expiration_time")
     */
    private $expirationTime;

    /**
     * @var ProductVariant|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product\ProductVariant")
     * @ORM\JoinColumn(name="product_variant_id", referencedColumnName="id")
     */
    private $productVariant;

    /**
     * @var Customer|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    public function getId(): int
    {
        return $this->id;
    }

    public function getExpirationTime(): ?\DateTimeInterface
    {
        return $this->expirationTime;
    }

    public function setExpirationTime(?\DateTimeInterface $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }

    public function getProductVariant(): ?ProductVariant
    {
        return $this->productVariant;
    }

    public function setProductVariant(?ProductVariant $productVariant): void
    {
        $this->productVariant = $productVariant;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }
}
