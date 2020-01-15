<?php
namespace App\Backend\Modules\Connexion;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class ConnexionController extends BackController
{
  public function executeConnexion(HTTPRequest $request)
  {
    $this->app->httpResponse()->redirect('/connect.html');
  }
}



