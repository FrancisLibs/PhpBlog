<?php
namespace App\Frontend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\User;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\RegistrationFormBuilder;
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

      if (empty($user->login()) || empty($user->password())) // Tous les champs sont remplis ?
      {
        $this->app->user()->setFlash('Merci de remplir les deux champs de saisie');

        $this->app->httpResponse()->redirect('/connect.html');
      }
      else
      {
        $manager = $this->managers->getManagerOf('User');
        $userBdd = $manager->getUser($user->login());

        if(is_null($userBdd)) // Si l'utilisateur n'existe pas dans la bdd
        {

          $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
          $this->app->httpResponse()->redirect('/connect.html');
        }
        else // Check du mot de passe
        {
          $mdpUser = $user->passwordHash($user->password());
          $compareResult = $user->comparePasswords($userBdd->password(), $mdpUser);

          if(!$compareResult){
            $this->app->user()->setFlash('L\'identifiant et/ou le mot de passe sont erronés');
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
        'email' =>          $request->postData('email'),
        'password' =>       $request->postData('password'),
        'verifyPassword' => $request->postData('verifyPassword'),
      ]);

      // Vérification de la validité du formulaire (tous champs remplis)
      if (!$user->registrationFormIsValid())
      {
        $this->app->user()->setFlash('Merci de compléter tous les champs');

        $this->app->httpResponse()->redirect('/register.html');
      }
      else
      {
        // Vérification de l'absence du pseudo en bdd
        $manager = $this->managers->getManagerOf('User');
        $resultat = $manager->count($user->login());

        if ($resultat <> 0)
        {
          $this->app->user()->setFlash('L\'identifiant que vous avez choisi est déjà pris');

          $this->app->httpResponse()->redirect('/register.html');
        }
        else
        {
          // Comparaison des 2 mots de passe du formulaire
          if(!($user->password() == $user->verifyPassword()))
          {
            $this->app->user()->setFlash('Les mots de passe ne sont pas identiques');

            $this->app->httpResponse()->redirect('/register.html');
          }
          else
          {
            // Ecriture de $user dans la bdd avec status à 0 et le mot de passe haché
            // On récupère le manager des users.
            $user->setStatus(0);
            $user->setPassword($user->passwordHash());

            $manager->add($user);

            // envoi du mail

            $this->app->user()->setFlash('Un mail d\'authentification vient de vous être envoyé');
            $this->app->httpResponse()->redirect('/./');
          }
        }
      }

    }
    else
    {
      $user = new User;
    }

    $formBuilder = new RegistrationFormBuilder($user);
    $formBuilder->build();

    $form = $formBuilder->form();

    $this->page->addVar('form', $form->createView());

    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Enregistrement');
  }
}
