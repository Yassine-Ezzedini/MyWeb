<?php

namespace minipoBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', TextType::class)
            ->add('description', TextType::class)
            ->add('prix', TextType::class)
            ->add('qtestock', TextType::class)
            ->add('photo', FileType::class, array('label'=>'Upload Product Photo'))
            ->add('idf', EntityType::class, [
                'class' => 'minipoBundle:Fournisseur',
                'choice_label' => 'nom',
            ])
            ->add('idcateg', EntityType::class, [
                'class' => 'minipoBundle:Categorie',
                'choice_label' => 'nom',
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'minipoBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'minipobundle_produit';
    }


}
