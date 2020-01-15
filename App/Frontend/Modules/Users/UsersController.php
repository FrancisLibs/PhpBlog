<?php
namespace App\Frontend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Users;
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
      $users = new Users([
        'login' =>          $request->postData('login'),
        'password' =>       $request->postData('password'),
      ]);

      if (empty($users->login()) || empty($users->password())) // Tous les champs sont remplis ?
      {
        $this->app->user()->setFlash('Merci de remplir les deux champs de saisie');

        $this->app->httpResponse()->redirect('/connect.html');
      }
      else
      {
        $manager = $this->managers->getManagerOf('Users');
        $usersBdd = $manager->getUsers($users->login());

        if(empty($usersBdd)) // Si l'utilisateur n'existe pas dans la bdd
        {
          $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
          $this->app->httpResponse()->redirect('/connect.html');
        }
        else // Check du mot de passe
        {
          if(!password_verify($users->Password(), $usersBdd->password()))
          {
            $this->app->user()->setFlash('L\'identifiant et/ou le mot de passe sont erronés');
            $this->app->httpResponse()->redirect('/connect.html');
          }
          else
          {
            $this->app->user()->setAuthenticated(true);

            $this->app->user()->setAttribute('users', $usersBdd);

            $this->app->httpResponse()->redirect('/');
          }
        }
      }
    }
    else
    {
      $users = new Users;
    }
    $formBuilder = new ConnexionFormBuilder($users);
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
      $users = new Users([
        'login' =>          $request->postData('login'),
        'email' =>          $request->postData('email'),
        'password' =>       $request->postData('password'),
        'verifyPassword' => $request->postData('verifyPassword'),
      ]);

      // Vérification de la validité du formulaire (tous champs remplis)
      if (!$users->registrationFormIsValid())
      {
        $this->app->user()->setFlash('Merci de compléter tous les champs');

        $this->app->httpResponse()->redirect('/register.html');
      }
      else
      {
        // Vérification de l'absence du pseudo en bdd
        $manager = $this->managers->getManagerOf('Users');
        $resultat = $manager->count($users->login());

        if ($resultat <> 0)
        {
          $this->app->user()->setFlash('L\'identifiant que vous avez choisi est déjà pris');

          $this->app->httpResponse()->redirect('/register.html');
        }
        else
        {
          // Comparaison des 2 mots de passe du formulaire
          if(!($users->password() == $users->verifyPassword()))
          {
            $this->app->user()->setFlash('Les mots de passe ne sont pas identiques');

            $this->app->httpResponse()->redirect('/register.html');
          }
          else
          {
            // Ecriture de $users dans la bdd avec status à 0 et le mot de passe haché
            // On récupère le manager des users.
            $users->setStatus(0);
            $users->setPassword($users->passwordHash());

            $manager->add($users);

           /* // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587))
              ->setUsername('fr.libs@gmail.com')
              ->setPassword('Cathy2601@1962');

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
              ->setFrom(['john@doe.com' => 'John Doe'])
              ->setTo(['fr.libs@gmail.com' => 'Francis'])
              ->setBody($request->postData('message'))
              ;

            // Send the message
            $result = $mailer->send($message); */

            $this->app->user()->setFlash('Un mail d\'authentification vient de vous être envoyé');
            $this->app->httpResponse()->redirect('/./');
          }
        }
      }

    }
    else
    {
      $users = new Users;
    }

    $formBuilder = new RegistrationFormBuilder($users);
    $formBuilder->build();

    $form = $formBuilder->form();

    $this->page->addVar('form', $form->createView());

    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Enregistrement');
  }

  public function executeDeconnect(HTTPRequest $request)
  {
    // Supression des variables de session et de la session
    $_SESSION = array();
    session_destroy();

    $this->app->httpResponse()->redirect('/');
  }
}
