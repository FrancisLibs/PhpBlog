<?php
namespace App\Backend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Users;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\RegistrationFormBuilder;
use \OCFram\FormHandler;


class UsersController extends BackController
{
  public function executeshow(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des utilisateurs');

    $manager = $this->managers->getManagerOf('Users');

    $this->page->addVar('listeUsers', $manager->getList());
    $this->page->addVar('nbUsers', $manager->count(0));
  }

  public function executeDeconnect()
  {
    // Supression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    $this->app->httpResponse()->redirect('/');
  }
}
