<?php

namespace minipoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //lorseque tu va ajouter image fournisseur, tensech tna7i el point virgule ta3 adresse ->add('image');
        $builder
            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('email',TextType::class )
            ->add('tel',TextType::class)
            ->add('adresse',TextType::class);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'minipoBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'minipobundle_user';
    }


}
