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
  public function executeShow()
  {
    // Gestion des droits
    $userSessionRole=$this->app->user()->getAttribute('users')->role();
   
    if($userSessionRole < 2)
    {
        $this->app->user()->setFlash('La gestion des membres, est réservbée aux administrateur');
        $this->app->httpResponse()->redirect('/admin/');
    }
    else
    {
      
        $this->page->addVar('title', 'Gestion des utilisateurs');

        $manager = $this->managers->getManagerOf('Users');

        $this->page->addVar('listeUsers', $manager->getList());
        $this->page->addVar('nbUsers', $manager->count(0));
    }
  }

  public function executeDeconnect()
  {
    // Supression des variables de session et de la session
    $this->app->user()->endSession();
    
    $this->app->httpResponse()->redirect('/');
  }

  public function executeUpgrade()
  {
    // Gestion des droits
    $userSessionRole=$this->app->user()->getAttribute('users')->role();
    if($userSessionRole < 3)
    {
        $this->app->user()->setFlash('pour gérer les utilisateurs, il faut être super-administrateur');
        $this->app->httpResponse()->redirect('/admin/users.html');
    }
    
    $this->page->addVar('title', 'Gestion des administrateurs');

    $manager = $this->managers->getManagerOf('Users');

    $this->page->addVar('listeUsers', $manager->getList());
    $this->page->addVar('nbUsers', $manager->count(0));

    $this->app->httpResponse()->redirect('/admin/users.html');
  }
  
  public function executeDelete(HTTPRequest $request)
  {
    // Gestion des droits
    $userSessionRole=$this->app->user()->getAttribute('users')->role();
    if($userSessionRole < 3)
    {
        $this->app->user()->setFlash('pour gérer les utilisateurs, il faut être super-administrateur');
        $this->app->httpResponse()->redirect('/admin/users.html');
    }
      
    $this->page->addVar('title', 'Suppresssion utilisateur');
    
    $usersId = $request->getData('id');
    
    $userConnecte=$this->app->user()->getAttribute('users');
    if ($usersId == $userConnecte->id())
    {
        $this->app->user()->endSession();
    }
    // Suppression des commentaires
    $commentManager = $this->managers->getManagerOf('Comment');
    $commentManager->deleteFromUsers($usersId);
    
    // Suppression des posts
    $postManager = $this->managers->getManagerOf('Post');
    $postManager->deleteFromUsers($usersId);
    
    // Suppression de l'utilisateurs
    $usersManager = $this->managers->getManagerOf('Users');
    $usersManager->delete($usersId);
    
    $this->app->httpResponse()->redirect('/admin/users.html');
  }
}
