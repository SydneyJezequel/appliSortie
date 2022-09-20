<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a firstname',
                    ]),
                    new Length([
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name',
                    ]),
                    new Length([
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a phone number',
                    ]),
                    new Length([
                        'max' => 30,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an adress email',
                    ]),
                    new Length([
                        'max' => 180,
                    ]),
                ],

            ])
            ->add('isAdministrateur', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Administrateur',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'choices' =>[
                    'oui' => true,
                    'non' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'data' => false
            ])
            ->add('campus', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Campus',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'class' => Campus::class,
                'choice_label' => 'nom',
            ])
            ->add('isActif', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Activité',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'choices' =>[
                    'activé' => true,
                    'désactivé' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'data' => true
            ])
//            ->add('rememberMe', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'Se souvenir de moi',
//                    ]),
//                ],
//            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
