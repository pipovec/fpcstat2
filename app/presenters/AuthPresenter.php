<?php

namespace App\Presenters;

use Nette,       
    App\Model;


class AuthPresenter extends BasePresenter
{
    /** @var \App\Model\Repository @inject */
    public $Repository;

    private $id = "883ff6ceefb13177357ffea34d6fb06f";
    private $expires_at = 1209600; // two weeks
    private $redirect = "http://127.0.0.1:8881/auth/";
    private $url = 'https://api.worldoftanks.eu/wot/auth/login/';
    private $request;    

    function  __construct(Nette\Http\Request $request) {       
        $this->request = $request;        
    }
    
    public function renderDefault() 
    {
        $this->template->dump =  $this->Identity();
    }

    public function renderClassic() 
    {   
        
        $section = $this->Identity();

        $this->template->dump =  $section->isLogged;   
    }

    private function Identity() 
    {
        $session = $this->getSession();
        $section = $session->getSection('Identity');   

        return $section;
    }


    public function handleWGAuth()
    {
        $data = array('application_id' => $this->id, 'expires_at' => $this->expires_at, 'redirect_uri' => $this->redirect);
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($options);

        $result = file_get_contents($this->url, false, $context);

        var_dump($result);

        return $result;



    }

    public function handleCheckPass() {
        
        $account_id = $_POST['account_id']; 
        $nickname = $_POST['nick'];       
        
        $section = $this->Identity();        

        $credits = $this->Repository->PlayersPass()->where('account_id', $account_id);
       
        $result = $credits->fetch();

        $count = $credits->count('*');

        if($count == 1) {

            if(password_verify($_POST['password'],$result->password)) {               
                
                $section->account_id = $account_id;
                $section->nickname = $nickname;
                $section->isLogged = TRUE;
                $data = ['isLogged' => true, 'account_id'=> $account_id, 'nickname'=> $nickname, 'reason' => 'ok'];
                return $this->sendResponse(new \Nette\Application\Responses\JsonResponse($data, "application/json;charset=utf-8")); 
            }
            else {
                $section->isLogged = false;
                $data = ['isLogged' => false, 'account_id'=> $account_id, 'nickname'=> $nickname, 'reason' => 'password_false'];
                return $this->sendResponse(new \Nette\Application\Responses\JsonResponse($data, "application/json;charset=utf-8")); 
            }

        }
        else {            
            
            $section->account_id = 0;
            $section->isLogged = false; 

            $data = ['isLogged' => false, 'account_id'=> 0, 'reason' => 'no_account' ];                        
            return $this->sendResponse(new \Nette\Application\Responses\JsonResponse($data, "application/json;charset=utf-8"));    
        }
    }
}