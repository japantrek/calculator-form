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
    private $calculator;

    /**
     * @param Calculator $calculator
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
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
}