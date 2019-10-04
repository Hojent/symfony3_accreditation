<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\UserProfileType;
use AppBundle\Entity\Smi;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('email')
            ->remove('current_password')
            ->add('smi',EntityType::class, [
                'label' => 'forms.labels.smi',
                'class' => Smi::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.title', 'ASC');
                },
                'attr' => ['class' => 'form-control'],
            ])
            ->add('userprofile', UserProfileType::class, ['label' => 'Личные данные']);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }
}


