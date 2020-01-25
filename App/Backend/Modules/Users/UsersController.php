<?php
namespace App\Backend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;

class UsersController extends BackController
{
  public function executeShow()
  {
    $this->page->addVar('title', 'Gestion des utilisateurs');

    $manager = $this->managers->getManagerOf('Users');

    $this->page->addVar('listeUsers', $manager->getList('users'));
    
    $this->page->addVar('nbUsers', $manager->count(0));
  }

  public function executeDeconnect()
  {
    // Supression des variables de session et de la session
    $this->app->user()->endSession();
    
    $this->app->httpResponse()->redirect('/');
  }

  public function executeUpgrade(HTTPRequest $request)
  {       
    $usersId = $request->getData('id');
      
    $this->page->addVar('title', 'Gestion des utilisateurs');

    $manager = $this->managers->getManagerOf('Users');
    $users=$manager->getUsersId($usersId);
    
    $usersRole = $users->role_id();
    $newRole = $usersRole+1;
    $users->setRole_id($newRole);
    $manager->update($users);

    $this->app->httpResponse()->redirect('/admin/users.html');
  }
  
  public function executeDelete(HTTPRequest $request)
  {      
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
  
  public function executeShowAdmin()
  {
    $manager = $this->managers->getManagerOf('Users');
    $this->page->addVar('listeUsers', $manager->getList('admin'));
  }
}
