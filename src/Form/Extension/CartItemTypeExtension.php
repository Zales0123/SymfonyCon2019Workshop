<?php

declare(strict_types=1);

namespace App\Form\Extension;

use App\Model\SubscriptionPeriods;
use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class CartItemTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('subscriptionPeriod', ChoiceType::class, [
            'label' => 'app.ui.subscription_period',
            'choices' => [
                'app.ui.subscription_periods.month' => SubscriptionPeriods::MONTH,
                'app.ui.subscription_periods.year' => SubscriptionPeriods::YEAR,
            ],
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [CartItemType::class];
    }
}
