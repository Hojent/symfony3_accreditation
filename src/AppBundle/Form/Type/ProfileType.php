<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Form\UserProfileType;
use AppBundle\Entity\Smi;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)  //edit_form
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
            ->add('pict_file_name', FileType::class, [
                'label' => 'Изменить фото (JPG)',
                'mapped' => false,
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Неверный формат файла',
                    ])
                ],
            ])
            ->add('doc1', FileType::class, [
                'mapped' => false,
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '256k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла',
                    ])
                ],
            ])
            ->add('doc2', FileType::class, [
                'mapped' => false,
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '256k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла',
                    ])
                ],
            ])
            ->add('doc3', FileType::class, [
                'mapped' => false,
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '256k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла',
                    ])
                ],
            ])
            ->add('userprofile', UserProfileType::class, [
                'label' => 'Личные данные',

            ])

        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }
}


