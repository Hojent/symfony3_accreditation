<?php

namespace AppBundle\Form;

use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('organizator', TextareaType::class, [
                'label' => 'Организаторы'
            ])
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
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'label' => 'Регион',
                'attr' => ['class' => 'form-control']
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                //'choices' => $builder->getData()->getRegion(),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                       // ->where('c.region = :region')
                       // ->setParameter('region', 2)

                        ->orderBy('c.name', 'ASC');
                },
                'label' => 'Город',
                'attr' => ['class' => 'form-control']
            ])
            /*->add('city', null, [
                'label' => 'Город',
            ])*/
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
