<?php
namespace App\Presenters;
use Nette,
    App\Model;


abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    
    /** @var \App\Model\Repository @inject */
    public $Repository;

    function __construct() 
    {
        
    }
    
    protected function SaveRequest() 
    {
        $data =  $this->getHttpRequest();

        $url            = $data->getUrl();
        $method         = $data->getMethod();
        $address        = $data->getRemoteAddress();
        $host           = $data->getRemoteHost();

        //$this->Repository->Stats()->insert(["url" => $url, "method" => $method, "address" => $address, "host" => $host]);

    }
    

    protected function Identity() 
    {
        $session = $this->getSession();
        $section = $session->getSection('Identity');   

        return $section;
    }
}