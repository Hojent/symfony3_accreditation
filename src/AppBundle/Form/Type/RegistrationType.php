<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Smi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('smi',EntityType::class, [
            'label' => 'forms.labels.smi',
            'class' => Smi::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.title', 'ASC');
            },

        ])
            ->add('userprofile', UserProfileOneType::class, ['label' => 'Личные данные']);
    }

    public function getParent()
    {
        return "FOS\UserBundle\Form\Type\RegistrationFormType";
    }

}
