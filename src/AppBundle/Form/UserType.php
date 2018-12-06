<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control col-md-8'
                )
            ))
            ->add('lastname', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control col-md-8'
                )
            ))
            ->add('zipcode', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control col-md-8'
                )
            ))
            ->add('phone', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control col-md-8'
                )
            ))
            ->add('company', EntityType::class, array(
                'class' => 'AppBundle:company',
                'choice_label' => 'name',
                'attr' => array(
                    'class' => 'form-control col-md-8'
                )
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
