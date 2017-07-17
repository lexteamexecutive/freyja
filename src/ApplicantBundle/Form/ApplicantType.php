<?php

namespace ApplicantBundle\Form;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Form\EvaluationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApplicantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                ]
            )
            ->add(
                'civilStatus',
                ChoiceType::class,
                [
                    'required'    => false,
                    'placeholder' => false,
                    'choices'     => [
                        'Marié(e)'     => 'MARIED',
                        'Célibataire'  => 'SINGLE',
                        'PACSE'        => 'CIVIL_CONTRACT',
                        'Concubinage'  => 'LIVING_COUPLE',
                        'Vie maritale' => 'LIVING_MARIED',
                        'Indéfini'     => 'UNKNOWN',
                    ],
                    'preferred_choices' => [
                        'UNKNOWN',
                    ],
                ]
            )
            ->add(
                'sexe',
                ChoiceType::class,
                [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => false,
                    'placeholder' => false,
                    'choices' => array(
                        'Homme' => 'H',
                        'Femme' => 'F',
                    ),
                ]
            )
            ->add(
                'address',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'email1',
                EmailType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'email2',
                EmailType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'portable1',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'portable2',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'cv',
                FileType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'evaluation',
                EvaluationType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Applicant::class,
        ));
    }
}
