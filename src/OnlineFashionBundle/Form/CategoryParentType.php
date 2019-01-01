<?php

namespace OnlineFashionBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use OnlineFashionBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryParentType extends AbstractType
{
    /**
     * @var ArrayCollection|Category[]
     */
    private $categories;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('catName', TextType::class)
            ->add('parentCats', ChoiceType::class, array(
                'choice_loader' => new CallbackChoiceLoader(function() {
                    return $this->categories;
                }),
            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OnlineFashionBundle\Entity\Category'
        ));
    }

    public function __construct()
    {
        $this->categories= new ArrayCollection();
    }
    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function setCategories($category)
    {
        $this->categories[] = $category;
    }


}