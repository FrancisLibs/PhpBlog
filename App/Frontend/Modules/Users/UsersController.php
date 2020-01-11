<?php
namespace App\Frontend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\User;
use \FormBuilder\ConnexionFormBuilder;
use \OCFram\FormHandler;

class UsersController extends BackController
{
  public function executeConnexion(HTTPRequest $request)
  {
    // Traitement du formulaire s'il a été envoyé
    if ($request->method() == 'POST')
    {
      $user = new User([
        'login' =>          $request->postData('login'),
        'password' =>       $request->postData('password'),
      ]);

      if (!$user->isValid())
      {
        $this->app->user()->setFlash('Merci de remplir les deux champs de saisie');

        $this->app->httpResponse()->redirect('/connect.html');
      }
      else
      {
        // On récupère le manager des users.
        $manager = $this->managers->getManagerOf('User');
        // et le user correspondnat au login
        $userBdd = $manager->getUser($user->login());

        if(!isset($userBdd))
        {
          $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
          $this->app->httpResponse()->redirect('/connect.html');
        }
        else
        {
          $compareResult = $user->comparePasswords($userBdd->password(), $user->password());

          if(!$compareResult){
            $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
            $this->app->httpResponse()->redirect('/connect.html');
          }
          else
          {
            $this->app->user()->setAuthenticated(true);
            $this->app->httpResponse()->redirect('.');
          }
        }
      }
    }
    else
    {
      $user = new User;
    }

    $formBuilder = new ConnexionFormBuilder($user);
    $formBuilder->build();

    $form = $formBuilder->form();

    //$this->page->addVar('message', $message);
    $this->page->addVar('form', $form->createView());

     // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Connexion');
  }

  public function executeRegistration(HTTPRequest $request)
  {
    // Traitement du formulaire s'il a été envoyé
    if ($request->method() == 'POST')
    {
      $user = new User([
        'login' =>          $request->postData('login'),
        'password' =>       $request->postData('password'),
        'verifyPassword' => $request->postData('vefifyPassword'),
      ]);

      if (!($user->password() == $user->verifyPassword())){

        $this->app->user()->setFlash('Les deux mots de passe sont différents');

        $this->app->httpResponse()->redirect('/./');
      }

      $resultat = $this->managers->getManagerOf('User')->getUser($user->login());

      $verification = $user->password_verify($user->login(), $resultat['login']);

      if($verification){
        $this->app->user()->setAuthenticated(true);
        $this->app->httpResponse()->redirect('.');
      }

    }
    else
    {
      $user = new User;
    }

    $formBuilder = new LoginFormBuilder($user);
    $formBuilder->build();

    $form = $formBuilder->form();

    $this->page->addVar('form', $form->createView());

    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Connexion');
  }
}
