<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

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
                'empty_data'=>'undefined',
                'placeholder'=>'Sélectionner une ville'
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'multiple' => false,
                'expanded' => false,
                'label' => 'Lieux',
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder'=>'Sélectionner un lieu'
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }


    protected function addElements(FormInterface $form, Ville $ville = null) {
    // Charger les villes dans le formulaire à partir de la classe ville.
    $form->add('ville', EntityType::class, array(
        'required' => true,
        'data' => $ville,
        'mapped'=>false,
        'placeholder' => 'Selectionner une ville...',
        'class' => Ville::class
    ));
    // Les lieux sont vides. Sauf si on sélectionne une ville.
    $lieux = array();
    // Si une ville est sélectionnée, il faut charger les lieux de cette ville.
    if ($ville) {
        $lieux = $ville->getLieux();
    }
    // Puis charger les lieux récupérés dans le formulaire :
    $form->add('lieu', EntityType::class, array(
        'required' => true,
        'placeholder' => 'Selectionne un lieu ...',
        'class' => Lieu::class,
        'choices' => $lieux
    ));
}

// Evènement déclenché avant la soumission du formulaire :
function onPreSubmit(FormEvent $event) {
    $form = $event->getForm();
    $data = $event->getData();

    // On récupère la ville et on la transforme en entité pour l'injecter dans le formulaire qui est soumit
    $ville = $this->em->getRepository(Ville::class)->find($data['ville']);

    $this->addElements($form, $ville);
}

// Evènement déclenché avant l'affichage du formulaire :
function onPreSetData(FormEvent $event) {
    $sortie = $event->getData();
    $form = $event->getForm();

    // On récupère la ville à partir des Lieux. Pour appeler les villes, on va utiliser la méthode getLieux() de l'entité Sortie :
    $ville = $sortie->getLieu() ? $sortie->getLieu()->getVille() : null;
    // Puis on injecte la liste des villes dans le formulaire ou elles seront affichées :
    $this->addElements($form, $ville);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }




}