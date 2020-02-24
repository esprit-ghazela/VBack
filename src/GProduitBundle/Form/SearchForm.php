<?php


namespace GProduitBundle\Form;

use Doctrine\DBAL\Types\TextType;
use GProduitBundle\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('q', TextType::class, [
            'label' => false ,
        'required' =>false,
        'attr' => [
            'placeholder' => 'Rechercher'
        ]
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => SearchData::class,
            'method'=>'GET',
            'csrf_protection' =>false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}