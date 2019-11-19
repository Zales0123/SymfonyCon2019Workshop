<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Customer\Customer;
use App\Entity\Product\ProductVariant;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

final class SubscriptionType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('expirationTime', DateTimeType::class);
        $builder->add('productVariant', EntityType::class, [
            'class' => ProductVariant::class,
            'choice_label' => 'code',
        ]);
        $builder->add('customer', EntityType::class, [
            'class' => Customer::class,
            'choice_label' => 'email',
        ]);
    }
}
