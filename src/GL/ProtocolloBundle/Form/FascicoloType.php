<?php

namespace GL\ProtocolloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FascicoloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoria')
            ->add('nome')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GL\ProtocolloBundle\Entity\Fascicolo'
        ));
    }

    public function getName()
    {
        return 'gl_protocollobundle_fascicolotype';
    }
}
