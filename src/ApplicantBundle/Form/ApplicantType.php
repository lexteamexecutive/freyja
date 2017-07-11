<?php

namespace ApplicantBundle\Form;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Form\EvaluationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApplicantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'required' => false,
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Nom',
                    'required' => false,
                ]
            )
            ->add(
                'cv',
                FileType::class,
                [
                    'label' => 'CV',
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
