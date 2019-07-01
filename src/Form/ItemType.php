<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ItemType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nazwa'])
            ->add('amount', null, [
                'label' => 'Ilość',
                'attr' => ['class' => 'amount']
                ])
            ->add('unit', null, ['label' => 'Jednostka'])
            ->add('netPrice', MoneyType::class,
                ['label' => 'Cena netto',
                'currency' => 'PLN',
                'attr' => ['class' => 'netPrice']
            ])
            ->add('vat', ChoiceType::class,
                [
                'label' => 'Vat',
                'choices' => [
                    '5%' => 5,
                    '8%' => 8,
                    '23%' => 23
                ],
                'placeholder' => 'Wybierz stawkę VAT',
                'attr' => ['class' => 'vat']
            ])
            ->add('netValue', MoneyType::class,
                [
                'mapped' => false,
                'label' => 'Wartość netto',
                'currency' => 'PLN',
                'attr' => ['class' => 'netValue', 'disabled' => true]
            ])
            ->add('grossValue', MoneyType::class,
                [
                'mapped' => false,
                'label' => 'Wartość brutto',
                'currency' => 'PLN',
                'attr' => ['class' => 'grossValue', 'disabled' => true]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Item::class]);
    }
}