<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\CustomerInterface;
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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="product_name")
     */
    private $productName;

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

    public function __construct(string $productName, CustomerInterface $customer, \DateTimeInterface $expirationTime)
    {
        $this->productName = $productName;
        $this->customer = $customer;
        $this->expirationTime = $expirationTime;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    public function getExpirationTime(): \DateTimeInterface
    {
        return $this->expirationTime;
    }
}
