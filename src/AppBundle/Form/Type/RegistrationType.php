<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Smi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Form\Type\RegistrationFormType as RegType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('smi', EntityType::class, [
                'class' => Smi::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.title', 'ASC');
                },
                'label' => 'СМИ',
                'attr' => ['class' => 'form-control']
            ])
            ->setMethod('GET')
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

}
