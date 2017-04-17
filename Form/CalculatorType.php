<?php
namespace nvbooster\CalculatorBundle\Form;

use nvbooster\Calculator\Calculator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * CalculatorType
 *
 */
class CalculatorType extends AbstractType
{
    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /* @var $calculator Calculator */
                $calculator = $event->getData()->_calculator();
                $builder = $event->getForm();

                foreach (array_keys($calculator->getInputsData()) as $inputName) {
                    $choices = $calculator->getInputValuesList($inputName);

                    if (is_array($choices)) {
                        $num = count($choices);
                        if (!$num) {
                            $builder->add($inputName, 'hidden', array('data' => ''));
                        } elseif (1 == $num) {
                            list($key) = each($choices);
                            $builder->add($inputName, 'hidden', array('data' => $key));
                        } elseif (5 > $num) {
                            $builder->add($inputName, 'choice', array(
                                'label' => $calculator->getInputLabel($inputName),
                                'choices' => $choices,
                                'expanded' => true
                            ));
                        } else {
                            $builder->add($inputName, 'choice', array(
                                'label' => $calculator->getInputLabel($inputName),
                                'choices' => $choices,
                                'expanded' => false
                            ));
                        }

                    } else {
                        $builder->add($inputName, 'text', array(
                            'label' => $calculator->getInputLabel($inputName),
                        ));
                    }
                }
            });
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Form\AbstractType::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => null,
            'data_class' => 'nvbooster\CalculatorBundle\Model\CalculatorProxy',
            'required' => false,
            'csrf_protection' => false,
            'by_reference' => true
        ));
    }

    /**
     * {@inheritDoc}
     *
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'calculator';
    }
}