<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Smi;
use AppBundle\Entity\UserProfile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('smi',EntityType::class, [
            'class' => Smi::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.title', 'ASC');
            },
            'label' => 'СМИ',
            'attr' => ['class' => 'form-control']
        ])
            ->setMethod('GET');
    }

    public function getParent()
    {
        return "FOS\UserBundle\Form\Type\RegistrationFormType";
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration2';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                //'data_class' => UserProfile::class,
            ]
        );
    }

}
