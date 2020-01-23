<?php
namespace App\Frontend\Modules\Users;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Users;
use \FormBuilder\ConnexionFormBuilder;
use \FormBuilder\RegistrationFormBuilder;
use \OCFram\FormHandler;
use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Message;

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
      else // Verification de la présence de l'identifiant en bdd
      {
        $usersBdd = $this->managers->getManagerOf('Users')->getUsers($users->login());
       
        if(empty($usersBdd)) // Si l'utilisateur n'existe pas dans la bdd
        {
          $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
          $this->app->httpResponse()->redirect('/connect.html');
        }
        else 
        {            
          if(!$users->comparePasswords($usersBdd->password()))  // Check du mot de passe
          {
            $this->app->user()->setFlash('L\'identifiant et/ou le mot de passe sont erronés');
            $this->app->httpResponse()->redirect('/connect.html');
          }
          else
          {
              if($usersBdd->status() == 0)
              {
                $this->app->user()->setFlash('Désolé, mais vous n\'êtes pas encore validé');
                
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
        $resultat = $manager->countUsers($users->login());

        if (!empty($resultat))
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
            // On récupère le manager des users.
            $users->setStatus(0);
            $users->setRole_id(1);
            $users->setPassword($users->passwordHash());

            //$manager->add($users);
            
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
              ->setUserName('fr.libs@gmail.com')
              ->setPassword('uaehjeerxotzfpqt');

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
              ->setFrom(['john@doe.com' => 'John Doe'])
              ->setTo(['fr.libs@gmail.com'])
              ->setBody('Here is the message itself')
              ;

            // Send the message
            $result = $mailer->send($message);

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

  public function executeDeconnect()
  {
    // Supression des variables de session et de la session
    $this->app->user()->endSession();
    
    $this->app->httpResponse()->redirect('/');
  }
}
