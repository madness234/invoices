<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InvoiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, ['label' => 'Numer faktury', 
                'attr' => ['readonly' => true]
                ])
            ->add('buyer', null,
                ['label' => 'Nabywca', 'attr' => ['class' => 'autocompleteSelect',
                    'data-url' => '/api/buyers.json']])
            ->add('issueDate', null,
                ['label' => 'Data wystawienia', 'widget' => 'single_text'])
            ->add('saleDate', null,
                ['label' => 'Data sprzedaży', 'widget' => 'single_text'])
            ->add('paymentDate', null,
                ['label' => 'Termin płatności', 'widget' => 'single_text'])
            ->add('paymentMethod', ChoiceType::class,
                [
                'label' => 'Metoda płatności',
                'choices' => Invoice::$paymentMethods,
                'placeholder' => 'Wybierz metode płatności',
            ])
            ->add('bankAccount', null, ['label' => 'Numer konta do przelewu'])
            ->add('items', CollectionType::class,
                [
                'entry_type' => ItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__name__',
                'label' => 'Pozycje na fakturze',
                'by_reference' => false
            ])
            ->add('save', SubmitType::class, ['label' => 'Zapisz'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Invoice::class,
            'cascade_validation' => true
        ));
    }
}