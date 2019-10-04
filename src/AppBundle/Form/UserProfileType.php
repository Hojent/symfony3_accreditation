<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('family',null, ['label' => 'forms.labels.family'])
            ->add('name', null, ['label'=> 'forms.labels.name' ])
            ->add('secondname', null, ['label'=> 'forms.labels.secondname'])
            ->add('databorn', null, ['label' => 'forms.labels.databorn'])
            ->add('privatenum', null, ['label'=> 'forms.labels.privatenum'])
            ->add('passportnum', null, ['label'=> 'forms.labels.passportnum'])
            ->add('issuedata', null, ['label'=> 'forms.labels.issuedata'])
            ->add('ruvd', null, [
                'label'=> 'forms.labels.ruvd',
                'attr' => ['placeholder' => 'Фрунзенским РУВД г.Минска']
                ])
            ->add('enddata', null, ['label'=> 'forms.labels.enddata'])
            ->add('place', null, ['label'=> 'forms.labels.place'])
            ->add('phone', null, [
                'label'=> 'forms.labels.phone',
                'attr' => ['placeholder' => '+375 XX XXX-XX-XX']
                ])
            ->add('address', null, ['label'=> 'forms.labels.address'])
            ->add('photo', null, ['label'=> 'forms.labels.photo'])
            ->add('application', null, ['label'=> 'forms.labels.application']);
            //->add('user');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('user')
            ->setDefaults([
            'data_class' => 'AppBundle\Entity\UserProfile'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_userprofile';
    }


}
