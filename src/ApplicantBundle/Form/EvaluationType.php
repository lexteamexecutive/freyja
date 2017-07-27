<?php

namespace ApplicantBundle\Form;

use ApplicantBundle\Entity\Evaluation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oathTaking',
                DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'firstExperience',
                DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'firstExperienceBis',
                DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'job',
                EntityType::class,
                [
                    'class' => 'ApplicantBundle:EvaluationJob',
                    'choice_label' => 'label',
                    'required' => false,
                ]
            )
            ->add(
                'speciality',
                EntityType::class,
                [
                    'class' => 'ApplicantBundle:EvaluationSpeciality',
                    'choice_label' => 'label',
                    'required' => false,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Evaluation::class,
        ));
    }
}
