<?php
namespace nvbooster\CalculatorForm\Form;

use nvbooster\Calculator\Calculator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use nvbooster\CalculatorForm\Model\CalculatorProxy;

/**
 * CalculatorType
 *
 */
class CalculatorType extends AbstractType
{
    /**
     * {@inheritDoc}
     *
     * @see AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /**
                 * @var CalculatorProxy $data
                 */
                $data = $event->getData();
                /* @var $calculator Calculator */
                $calculator = $data ->_calculator();
                $builder = $event->getForm();

                foreach (array_keys($calculator->getInputsData()) as $inputName) {
                    $config = $data->getConfig($inputName);
                    $choices = $calculator->getInputValuesList($inputName);

                    if (is_array($choices)) {
                        $num = count($choices);
                        if ($num > 1) {
                            $expandedThreshold = key_exists('radio_threshold', $config) ? (int) $config['radio_threshold'] : 5;
                            $forceExpanded = !empty($config['force_radio']);
                            $builder->add($inputName, ChoiceType::class, array(
                                'label' => $calculator->getInputLabel($inputName),
                                'choices' => array_flip($choices),
                                'choices_as_values' => true,
                                'expanded' => $forceExpanded || ($expandedThreshold > $num),
                            ));

                        } else {
                            list($key) = each($choices);
                            $builder->add($inputName, HiddenType::class, array('data' => $key ?: ''));
                        }
                    } else {
                        $builder->add($inputName, TextType::class, array(
                            'label' => $calculator->getInputLabel($inputName),
                        ));
                    }
                }
            });
    }

    /**
     * {@inheritDoc}
     *
     * @see AbstractType::configureOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'empty_data' => null,
            'data_class' => 'nvbooster\CalculatorForm\Model\CalculatorProxy',
            'required' => false,
            'csrf_protection' => false,
            'by_reference' => true
        ));
    }
}
