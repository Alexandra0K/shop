<?php

namespace OnlineFashionBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('basePrice', IntegerType::class)
            ->add('description', TextType::class)
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
            ))
            ->add('image', FileType::class, ['data' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OnlineFashionBundle\Entity\Article'
        ));
    }


}
