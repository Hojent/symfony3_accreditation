<?php

namespace AppBundle\Form;

use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('fil1', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => ' ',
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2056k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',

                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла',
                    ])
                ],
            ])
            ->add('fil2', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => ' ',
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2056k',
                        'mimeTypes' => [
                           'application/pdf',
                           'application/msword',
                           'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                           'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                           'application/vnd.ms-excel',
                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла',
                    ])
                ],
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
                'attr' => ['id' => 'event_region']
            ])
        ;

        $formModifier = function (FormInterface $form, Region $region = null) {
            $cites = null === $region ? [] : $region->getCites();
            $form->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Город',
                'placeholder' => 'В каком городе',
                'choices' => $cites,
                'attr' => ['id' => 'event_city']
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $eve) use ($formModifier) {
                $data = $eve->getData();
                $formModifier($eve->getForm(), $data->getRegion());
            }
        );
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $evnt) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $region = $evnt->getForm()->getData();
                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($evnt->getForm()->getParent(), $region);
            }
        );
        //$builder->setMethod('GET');
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
