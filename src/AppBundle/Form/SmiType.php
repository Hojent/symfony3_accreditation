<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SmiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Название СМИ',
                'required' => 'true'
            ])
            ->add('body',TextType::class, [
                'label' => 'Учреждение',
                'required' => 'true'
            ])
            ->add('head',TextType::class, [
                'label' => 'Руководитель',
                'required' => 'true'
            ])
            ->add('owner',TextType::class, [
                'label' => 'Учредитель',
                'required' => 'true'
            ])
            ->add('unp',TextType::class, [
                'label' => 'УНП',
                //'required' => 'true'
            ])
            ->add('tel',TextType::class, [
                'label' => 'Телефон',
                //'required' => 'true'
            ])
            ->add('address',TextType::class, [
                'label' => 'Адрес:',
                //'required' => 'true'
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'label' => 'Регион',
                'attr' => ['class' => 'form-control']
            ])
            ->setMethod('GET')

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Smi'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_smi';
    }


}
