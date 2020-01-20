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
  public function executeshow()
  {
    // Gestion des droits
     $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 3)
    {
        $this->app->user()->setFlash('pour gérer les utilisateurs, il faut être super-administrateur');
        $this->app->httpResponse()->redirect('/.html');
    }
      
    $this->page->addVar('title', 'Gestion des utilisateurs');

    $manager = $this->managers->getManagerOf('Users');

    $this->page->addVar('listeUsers', $manager->getList());
    $this->page->addVar('nbUsers', $manager->count(0));
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
    $userSession=$this->getAttribute('users');
    if($userSession->role()< 3)
    {
        $this->app->user()->setFlash('pour gérer les utilisateurs, il faut être super-administrateur');
        $this->app->httpResponse()->redirect('/.html');
    }
    
    $this->page->addVar('title', 'Gestion des administrateurs');

    $manager = $this->managers->getManagerOf('Users');

    $this->page->addVar('listeUsers', $manager->getList());
    $this->page->addVar('nbUsers', $manager->count(0));

  }
  
  public function executeDelete(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->getAttribute('users');
    if($userSession->role()< 3)
    {
        $this->app->user()->setFlash('pour gérer les utilisateurs, il faut être super-administrateur');
        $this->app->httpResponse()->redirect('/.html');
    }
      
    $this->page->addVar('title', 'Suppresssion utilisateur');
    
    $usersId = $request->getData('id');
    
    $userConnecte=$this->app->user()->getAttribute('users');
    if ($usersId == $userConnecte->id())
    {
        $this->app->user()->endSession();
    }
            
    $commentManager = $this->managers->getManagerOf('Comment');
    $postManager = $this->managers->getManagerOf('Post');
    $usersManager = $this->managers->getManagerOf('Users');
    
    $commentManager->deleteFromUsers($usersId);
    $postManager->deleteFromUsers($usersId);
    $usersManager->delete($usersId);
    
    $this->app->httpResponse()->redirect('/admin/users.html');
  }
}
