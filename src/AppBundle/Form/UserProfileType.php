<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\UserProfile;

class UserProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('family',TextType::class, ['label' => 'forms.labels.family'])
            ->add('name', TextType::class, ['label'=> 'forms.labels.name' ])
            ->add('secondname', TextType::class, ['label'=> 'forms.labels.secondname'])
            ->add('databorn',TextType::class,[
                'label' => 'forms.labels.databorn',
                'attr' => ['id' => 'dpd1', 'class' => 'col-sm-2', 'placeholder' => 'dd.mm.YYYY']
            ])
            ->add('privatenum', TextType::class, ['label'=> 'forms.labels.privatenum'])
            ->add('passportnum', TextType::class, ['label'=> 'forms.labels.passportnum'])
            ->add('issuedata',TextType::class,[
                'label' => 'forms.labels.issuedata',
                'attr' => ['id' => 'dpd2', 'class' => 'col-sm-2', 'placeholder' => 'dd.mm.YYYY']
            ])
            ->add('ruvd', TextType::class, [
                'label'=> 'forms.labels.ruvd',
                'attr' => ['placeholder' => 'Фрунзенским РУВД г.Минска']
                ])
            ->add('enddata',TextType::class,[
                'label' => 'forms.labels.enddata',
                'attr' => ['id' => 'dpd3', 'class' => 'col-sm-2', 'placeholder' => 'dd.mm.YYYY']
            ])
            ->add('place', TextType::class, ['label'=> 'forms.labels.place'])
            ->add('phone', TextType::class, [
                'label'=> 'forms.labels.phone',
                'attr' => ['placeholder' => '+375XXXXXXXXX']
                ])
            ->add('address', TextType::class, ['label'=> 'forms.labels.address'])
            //->add('photo', null, ['label'=> 'forms.labels.photo'])
            //->add('application', null, ['label'=> 'forms.labels.application']);
            //->add('user')
         ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined('user')
            ->setDefaults([
            'data_class' => UserProfile::class,
            'required' => false
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
