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
      // Le formulaire a t-il été détourné ? (CSRF)
      if($this->app->user()->sessionExist('formToken') && $request->postExists('formToken'))
      {
        if($request->postData('formToken') != $this->app->user()->sessionExist('formToken'))
        {
          $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
          $this->app->httpResponse()->redirect('/connect.html');
        }
      }

      $users = new Users([
        'login' =>          $request->postData('login'),
        'password' =>       $request->postData('password'),
      ]);

      if (empty($users->login()) || empty($users->password())) // Tous les champs sont remplis ?
      {
        $this->app->user()->setFlash('Merci de remplir les deux champs de saisie');
        $this->app->httpResponse()->redirect('/connect.html');
      }

      // Verification de la présence de l'identifiant en bdd
      // On récupère le manager des users.
      $manager = $this->managers->getManagerOf('Users');
      // et le user correspondant au login
      $usersBdd = $manager->getUsers($users->login());

      // test si présence en badd et test si bn mdp
      if(!isset($usersBdd) || (!$users->comparePasswords($usersBdd->password())))
      {
        $this->app->user()->setFlash('L\'identifiant ou le mot de passe sont erronés');
        $this->app->httpResponse()->redirect('/connect.html');
      }

      if($usersBdd->status() == 0)// Vérification validité de l'utilisateur
      {
        $this->app->user()->setFlash('Désolé, mais vous n\'êtes pas encore validé');
        $this->app->httpResponse()->redirect('/connect.html');
      }

      $this->app->user()->setAuthenticated(true);

      $this->app->user()->setAttribute('users', $usersBdd);

      $this->app->httpResponse()->redirect('/');

    }
    else
    {
      $users = new Users;
    }
    // CSRF...
    $formToken = bin2hex(random_bytes(20));
    $this->app->user()->setSession('formToken', $formToken);

    $users->setFormToken($formToken);

    $formBuilder = new ConnexionFormBuilder($users);

    $formBuilder->build();

    $form = $formBuilder->form();

    $this->page->addVar('form', $form->createView());

     // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Connexion');
  }

  public function executeRegistration(HTTPRequest $request)
  {
    // Traitement du formulaire s'il a été envoyé
    if ($request->method() == 'POST')
    {
       //On vérifie la présence des  tokens (CSRF)
      if (!empty($_SESSION['formToken']) AND !empty($request->postData('formToken')))
      {
        // Le formulaire a t-il été détourné ?
        if($request->postData('formToken') != $_SESSION["formToken"])
        {
          $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
          $this->app->httpResponse()->redirect('register.html');
        }
      }
      else
      {
        $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
        $this->app->httpResponse()->redirect('register.html');
      }

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

      // Vérification de l'absence du pseudo en bdd
      $manager = $this->managers->getManagerOf('Users');
      $resultat = $manager->countUsers($users->login());

      if (!empty($resultat))
      {
        $this->app->user()->setFlash('L\'identifiant que vous avez choisi n\'est pas disponible');
        $this->app->httpResponse()->redirect('/register.html');
      }

      if (!($users->password() == $users->verifyPassword())) // Comparaison des 2 mots de passe du formulaire
      {
        $this->app->user()->setFlash('Les mots de passe ne sont pas identiques');
        $this->app->httpResponse()->redirect('/register.html');
      }
    }
    else
    {
      $users = new Users;
    }

    $formToken = bin2hex(random_bytes(20));
    $_SESSION['formToken'] = $formToken;

    $users->setFormToken($formToken);

    $formBuilder = new RegistrationFormBuilder($users);
    $formBuilder->build();
    $form = $formBuilder->form();
    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Users'), $request);

    if ($formHandler->processValid())
    {
      $users->setStatus(0);
      $users->setRole_id(1);
      $users->setPassword($users->passwordHash());
      $users->setVkey(bin2hex(random_bytes(10)));

      $formHandler->processSave();

      $txtMessage= 'Bienvenue sur PhpBlog,

        Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
        ou copier/coller dans votre navigateur Internet.

        http://phpblog/activation-'.urlencode($users->login()).'-'.urlencode($users->vkey()).'.html

        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';

      // Envoi du mail de confirmation
      // Create the Transport
      $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'TLS'))
        ->setUserName('fr.libs@gmail.com')
        ->setPassword('uaehjeerxotzfpqt');

      // Create the Mailer using your created Transport
      $mailer = new Swift_Mailer($transport);

      // Create a message
      $message = (new Swift_Message('Activer votre compte'))
        ->setFrom(['fr.libs@gmail.com' => 'Francis Libs'])
        ->setTo([$users->email()])
        ->setBody($txtMessage);

      // Send the message
      $mailer->send($message);

      $this->app->user()->setFlash('Un mail d\'authentification vient de vous être envoyé');
      $this->app->httpResponse()->redirect('/');

    }

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

  public function executeActivation(HTTPRequest $request)
  {
    $login = $request->getData('log');
    $key = $request->getData('key');

    // Verification de la présence de l'identifiant en bdd
    $manager = $this->managers->getManagerOf('Users');
    $users = $manager->getUsers($login);


    if(!isset($users))
    {
      $this->app->user()->setFlash('La validation n\'est pas possible, vous n\'êtes pas connu du système');
      $this->app->httpResponse()->redirect('/');
    }

    if(!$users->vKey() == $key)  // Check de la clé
    {
      $this->app->user()->setFlash('La validation n\'est pas possible, vous n\'êtes pas connu du système');
      $this->app->httpResponse()->redirect('/');
    }

    $users->setStatus(1);

    $manager->update($users);

    $this->app->user()->setFlash('Félicitation, vous faites maintenant partie de nos membres');
    $this->app->httpResponse()->redirect('/');
  }
}
