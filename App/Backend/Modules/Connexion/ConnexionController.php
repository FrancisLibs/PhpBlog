<?php
namespace App\Backend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController
{
  public function executeConnexion()
  {
    $this->app->user()->setFlash('Merci de vous connecter');   
    $this->app->httpResponse()->redirect('/connect.html');
  }
}



