<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BannerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Текст для баннера',
                'required' => true
            ])
            ->add('fileName', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => ' ',
                'constraints' => [
                    new File([
                        'maxSize' => '256k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/pjpeg',
                            'image/gif',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Неверный размер или формат файла. Допустимые форматы:JPG, JPEG, GIF, PNG. Размер не более 256 кБ',
                    ])
                ],
            ])
            ->add('publish', CheckboxType::class, [
                'label'    => 'Публиковать',
                'required' => false,
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Banner'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_banner';
    }


}
