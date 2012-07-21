<?php

namespace GL\ProtocolloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProtocolloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anno')
            ->add('protocolloNumero')
            ->add('dataRegistrazione', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                ))
            ->add('protocolloPrecedente', 'entity', array(
                    'class' => 'GL\ProtocolloBundle\Entity\Protocollo',
                    'empty_value' => '',
                    'required' => false,
                ))
            ->add('tipo', 'choice', array(
                    'choices' => array('U' => 'Uscita', 'I' => 'Ingresso'),
                    'required' => true,
                    'expanded' => true,
                ))
            ->add('formato')
            ->add('intestazione')
            ->add('indirizzo')
            ->add('localita')
            ->add('dataDocumento', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                ))
            ->add('oggetto')
            ->add('protocolloDocumento')
            ->add('allegato','file')
            ->add('categoria')
            ->add('classificazione')
            ->add('fascicolo')
            ->add('utente')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GL\ProtocolloBundle\Entity\Protocollo'
        ));
    }

    public function getName()
    {
        return 'gl_protocollobundle_protocollotype';
    }
}
