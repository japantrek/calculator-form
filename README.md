# CalculatorForm integration

## Usage

```php

<?php
namespace Acme\AppBundle\Controller;

use nvbooster\Calculator\Calculator;
use nvbooster\CalculatorForm\Form\CalculatorType;
use nvbooster\CalculatorForm\Model\CalculatorProxy;
use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalculatorController extends Controller
{
    public function indexAction(Request $request)
    {
        $calculator = new Calculator();

        ...

        $form = $this->get('form.factory')
            ->create('mycalc', CalculatorType::class, new CalculatorProxy($calculator));
        
        $form->handleRequest($request);
                
    }
}
```