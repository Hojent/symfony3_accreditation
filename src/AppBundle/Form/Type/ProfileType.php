<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\UserProfile;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('family', TextType::class)
            ->add('name', TextType::class)
            ->add('secondname', TextType::class)
            ->add('databorn', DateType::class)
            ->add('privatenum', TextType::class)
            ->add('passportnum', TextType::class)
            ->add('issuedata', DateType::class)
            ->add('ruvd', TextType::class)
            ->add('enddata', TextType::class)
            ->add('place', TextType::class)
            ->add('phone', TextType::class)
            ->add('address', TextType::class)
            ->add('photo', FileType::class)
            ->add('application', FileType::class)
            ->setMethod('GET');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserProfile'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}


