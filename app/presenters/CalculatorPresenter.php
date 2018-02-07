<?php 


namespace App\Presenters;

use Nette;
   

class CalculatorPresenter extends BasePresenter
{
    function  __construct()
    {                      
        
    }

    function renderDefault()
    {
        $this->SaveRequest();
    }
}