<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Smi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

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
            ->add('pict_file_name', FileType::class, [
                'label' => 'Фото (JPG)',
                'mapped' => false,
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'images/jpg',
                            'images/pjpg',
                            'images/png',
                        ],
                        'mimeTypesMessage' => 'Неверный формат файла',
                    ])
                ],
            ])
            ->add('userprofile', UserProfileOneType::class, ['label' => 'Личные данные']);
    }

    public function getParent()
    {
        return "FOS\UserBundle\Form\Type\RegistrationFormType";
    }

}
