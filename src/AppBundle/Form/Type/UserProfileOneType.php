<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\UserProfileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileOneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('databorn')
            ->remove('passportnum')
            ->remove('issuedata')
            ->remove('ruvd')
            ->remove('enddata')
            ->remove('place')
            ->remove('phone')
            ->remove('address')
            ->remove('photo')
            ->remove('application');
        ;

    }

    public function getParent()
    {
        return 'AppBundle\Form\UserProfileType';

    }

}
