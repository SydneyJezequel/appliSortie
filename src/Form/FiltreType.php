<?php

namespace App\Form;

use App\Entity\Campus;
use App\Modele\Filtre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('campus',EntityType::class, [
                'label' => 'Campus',
                'class' => Campus::class,
                'attr' => [
                    'class' => 'form-control',
                ],
                'choice_label' => 'nom',
                'required'=>false,

            ])
            ->add('nom',TextType::class,  [
                'label'    => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'required'=>false,
            ])
            ->add('dateDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Entre',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'required'=>false,
            ])
            /*
            ->add('organisateur',CheckboxType::class,  [
                'label'    => 'Sorties dont je suis organisateur/trice',
                'required'      => false,
                'empty_data' => null,
            ])
            ->add('inscrit',CheckboxType::class,  [
                'label'    => 'Sorties auxquelles je suis inscrit/e',
                'required'      => false,
                'empty_data' => null,
            ])
            ->add('pasInscrit',CheckboxType::class,  [
                'label'    => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required'      => false,
                'empty_data' => null,
            ])
            ->add('passe',CheckboxType::class,  [
                'label'    => 'Sorties passées',
                'required'      => false,
                'empty_data' => null,
            ])*/
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => false,
            'data_class' => Filtre::class,
        ]);
    }

}