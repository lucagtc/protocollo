<?php

namespace GL\ProtocolloBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProtocolloType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anno')
                ->add('protocollo')
                ->add('tipo', 'choice', array(
                    'choices' => array('U' => 'Uscita', 'I' => 'Ingresso'),
                    'required' => true,
                    'expanded' => true,
                ))
                ->add('data', 'date', array(
                    'pattern' => '{{ day }}-{{ month }}-{{ year }}'
                ))
                ->add('formato')
                ->add('intestazione')
                ->add('indirizzo')
                ->add('localita')
                ->add('oggetto')
                ->add('protocolloDocumento')
                ->add('posizione')
                ->add('protocolloPrecedente', 'entity', array(
                    'class' => 'GLProtocolloBundle:Protocollo',
                    'empty_value' => '',
                    'required' => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'GL\ProtocolloBundle\Entity\Protocollo'
        ));
    }

    public function getName() {
        return 'gl_protocollobundle_protocollotype';
    }

}
