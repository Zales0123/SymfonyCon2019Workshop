<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Sylius\Component\Product\Model\ProductTranslationInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct
{
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $subscription = false;

    public function setSubscription(bool $subscription): void
    {
        $this->subscription = $subscription;
    }

    public function isSubscription(): bool
    {
        return $this->subscription;
    }

    protected function createTranslation(): ProductTranslationInterface
    {
        return new ProductTranslation();
    }
}
