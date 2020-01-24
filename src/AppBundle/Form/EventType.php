<?php

namespace AppBundle\Form;

use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     * Event|null $event
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
            ->add('address', TextType::class, ['label' => 'Адрес'])
            ->add('evtip', null, [
                'label' => 'Тип мероприятия',
            ])
           ->add('region', EntityType::class, [
                'class' => Region::class,
                'placeholder' => 'Выберите регион',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.name', 'ASC');
                },
                'required' => false,
                'label' => 'Регион',
                'attr' => ['class' => 'form-control']
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'placeholder' => 'Город',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'required' => false,
                'label' => 'Город',
                'attr' => ['class' => 'form-control']
            ])
        ;
        $builder->get('region')->addEventListener(FormEvents::POST_SUBMIT,
                        function(FormEvent $event) {
                            var_dump($event); die();
                        });


 /*       $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                    $data = $event->getData();
                    $form = $event->getForm();
                if (null == $region) {
                    $formOptions = [
                        'class' => City::class,
                        'placeholder' => 'Where exactly?',
                        //'choice_label' => 'fullName',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('c')
                                ->orderBy('c.name', 'ASC');
                        },
                        'required' => false,
                        'label' => 'Город',
                    ];
                }
                else {

                    $region = $data->getRegion()->getId();
                    $formOptions = [
                        'class' => City::class,
                        'placeholder' => 'Where exactly?',
                        //'choice_label' => 'fullName',
                        'query_builder' => function (EntityRepository $er) use ($region) {
                            return $er->createQueryBuilder('c')
                                ->where('c.region = :region')
                                ->setParameter('region', $region)
                                ->orderBy('c.name', 'ASC');
                        },
                        'required' => false,
                        'label' => 'Город',
                    ];

                }
                $form->add('city', EntityType::class, $formOptions);
            });*/

            $builder->setMethod('GET');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
             'data_class' => 'AppBundle\Entity\Event',
                ]);
        //    ->setRequired('entity_manager')

    }





}
