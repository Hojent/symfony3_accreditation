<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'label' => 'Название',
                'required' => 'true'
            ])
            ->add('brief', TextareaType::class, [
                'label' => 'Для прессы',
                'required' => 'true'
            ])
            ->add('organizator', TextareaType::class)
            ->add('dataStart',TextType::class,[
                'label' => 'Начало',
                'required' => 'true',
                'attr' => ['id' => 'dpd1', 'class' => 'col-sm-2']
            ])
            ->add('dataEnd', TextType::class, [
                'label' => 'Окончание',
                'attr' => ['id' => 'dpd2', 'class' => 'col-sm2']
            ])
            //->add('dataCreated', DateType::class, [
            //    'label' => 'создано',
            //    'attr' => ['class' => 'col-sm2']
            //])
            ->add('region',null, [
                'label' => 'Область'
            ])
            ->add('city', null, [
                'label' => 'Город',
            ])
            ->add('address', TextType::class, ['label' => 'Адрес'])
            ->add('evtip', null, [
                'label' => 'Тип мероприятия',
            ])
            ->setMethod('GET');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
             'data_class' => 'AppBundle\Entity\Event',

        ]);
    }

}
