<?php

declare(strict_types=1);

namespace Customize\Form\Type;

use Customize\Entity\Sale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'admin.sale.label.title',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'admin.sale.label.description',
                'required' => false,
            ])
            ->add('discount_type', ChoiceType::class, [
                'label' => 'admin.sale.label.discount_type',
                'choices' => [
                    'money' => 1,
                    'percent' => 2,
                ],
                'choice_label' => function ($value, $key, $index) {
                    return sprintf('admin.sale.choice.discount_type.%s', $key);
                },
                'choice_translation_domain' => 'messages',
                'placeholder' => false,
                'required' => true,
            ])
            ->add('discount_amount', MoneyType::class, [
                'label' => 'admin.sale.label.discount_amount',
                'currency' => 'VND',
                'required' => true,
            ])
            ->add('from_date', DateTimeType::class, [
                'label' => 'admin.sale.label.period',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => [
                    'class' => 'datepicker',
                    'data-toggle' => 'datepicker',
                    'placeholder' => 'yyyy-MM-dd HH:mm'
                ]
            ])
            ->add('to_date', DateTimeType::class, [
                'label' => 'admin.sale.label.period',
                'required' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'attr' => [
                    'class' => 'datepicker',
                    'data-toggle' => 'datepicker',
                    'placeholder' => 'yyyy-MM-dd HH:mm'
                ]
            ])
            ->add('visible', ChoiceType::class, [
                'label' => 'admin.sale.label.visible',
                'choices' => [
                    'yes' => true,
                    'no' => false,
                ],
                'choice_label' => function ($value, $key, $index) {
                    return sprintf('admin.sale.choice.visible.%s', $key);
                },
                'choice_translation_domain' => 'messages',
                'expanded' => false,
                'placeholder' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sale::class,
        ]);
    }
}
