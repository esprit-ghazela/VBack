<?php

namespace GProduitBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('description')
            ->add('prix')
            ->add('quantite')
            ->add('reference')
            ->add('partenaire')
            ->add('categorie',EntityType::class,array('class'=>'GProduitBundle:Categorie',
                'choice_label'=>'nom',
                'multiple'=>false,))
            ->add('marque',ChoiceType::class,['choices' =>
                [
                    'Atala'=>'Atala',
                    'Atom Bicycles'=>'Atom Bicycles',
                    'BH Bikes'=>'BH Bikes' ,
                    'Bianchi ' => 'Bianchi ',
                    'Bike by Me' => 'Bike by Me ',
                    'BMC'=>'BMC',
                    'BTwin' => 'BTwin',
                    'Cannondale Bicycles' => 'Cannondale Bicycles',
                    'Canyon ' => 'Canyon',
                    'Giant ' => 'Giant ',
                    'Kestrel' => 'Kestrel',
                ] ])
            ->add('image', FileType::class, array('label' => 'Image(JPG)',
                'data_class' => null
            ))
            ->add('review_rating', RatingType::class, ['stars' => 5])
            ->add('Valider',SubmitType::class)

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GProduitBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gproduitbundle_produit';
    }


}
