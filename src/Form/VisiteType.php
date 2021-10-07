<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    /**
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville')
            ->add('pays')
            ->add('datecreation', null, ['label' => 'date de creation'])
            ->add('note')
            ->add('avis')
            ->add('tempmin', null, ['label' => 'T° min'])
            ->add('tempmax', null, ['label' => 'T° max'])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    /**
     * 
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
