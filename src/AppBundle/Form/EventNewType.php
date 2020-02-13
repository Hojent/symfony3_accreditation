<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EventNewType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('fil1')
            ->remove('fil2')
        ;

    }

    public function getParent()
    {
        return 'AppBundle\Form\EventType';

    }

}
