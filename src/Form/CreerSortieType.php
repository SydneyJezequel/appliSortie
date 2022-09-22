<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nom de la sorties',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer le nom de la sorties',
                    ]),
                    new Length([
                        'max' => 30,
                    ]),
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date et heure de la sorties',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Indiquer la Date et heure de la sorties',
                    ]),
                    new GreaterThan([
                        'propertyPath' => 'parent.all[dateLimiteInscription].data'
                    ]),
                ]
            ])
            ->add('dateLimiteInscription', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date limite inscription',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Indiquer la Date limite inscription',
                    ]),
                    new LessThan([
                        'propertyPath' => 'parent.all[dateHeureDebut].data'
                    ]),
                ]
            ])
            ->add('nbInscriptionsMax', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nombre de places',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrer un nombre maximum de places',
                    ]),
                    new Length([
                        'min' => 1,
                    ]),
                ]
            ])
            ->add('duree', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'durée',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer une durée maximum',
                    ])
                ]
            ])
            ->add('infosSortie', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Descriptions et infos',
                'label_attr' => [
                    'class' => 'form_label'
                ],
            ])
            ->add('ville', EntityType::class, [
                'mapped' => false,
                'class' => Ville::class,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder'=>'Sélectionner une ville',
//                'empty_data' => ''

            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'multiple' => false,
                'expanded' => false,
                'label' => 'Lieux',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
            ->add('Publier', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);

    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }


}