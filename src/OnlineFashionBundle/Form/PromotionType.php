<?php

namespace OnlineFashionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('validFrom', DateType::class, array(
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('validTo', DateType::class, array(
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('reduction', NumberType::class)
            ->add('weight', NumberType::class)
            ->add('category', ChoiceType::class, array(
                'choices' => array(
                    'placeholder' => 'Please select',
                    'Women' => array(
                        'placeholder' => 'Please select',
                        'Shirts' => '3',
                        'Trousers' => '4',
                        'Shoes' => '5',
                        'Accessories' => '6',
                        'Coats' => '7',
                        'Dresses' => '8',
                        'Skirts' => '9',
                    ),
                    'Men' => array(
                        'placeholder' => 'Please select',
                        'Shirts' => '10',
                        'Trousers' => '11',
                        'Shoes' => '12',
                        'Accessories' => '13',
                        'Coats' => '14',
                    ),
                ),
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OnlineFashionBundle\Entity\Promotion'
        ));
    }




}
