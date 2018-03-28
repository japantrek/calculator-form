<?php
namespace nvbooster\CalculatorForm\Model;

use nvbooster\Calculator\Calculator;

/**
 * Прокси класс для использования калькулятора в Symfony Form
 *
 * @author nvb <nvb@aproxima.ru>
 */
class CalculatorProxy
{
    /**
     * @var Calculator
     */
    private $calculator;

    /**
     * @var array
     */
    private $config;

    /**
     * @param Calculator $calculator
     * @param array      $config
     */
    public function __construct(Calculator $calculator, $config = array())
    {
        $this->calculator = $calculator;
        $this->config = $config;
    }

    /**
     * @return Calculator
     */
    public function _calculator()
    {
        return $this->calculator;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function __get($name)
    {
        return $this->calculator->getInputValue($name);
    }

    /**
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $this->calculator->set($name, $value);
    }

    /**
     * @param array $field
     *
     * @return mixed
     */
    public function getConfig($field)
    {
        $field = (string) $field;

        return empty($this->config[$field]) ? array() : $this->config[$field];
    }
}
