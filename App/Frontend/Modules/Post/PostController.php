<?php
namespace App\Frontend\Modules\Post;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;
use \OCFram\Conf;
use \Entity\Comment;
use \Entity\Message;
use \FormBuilder\MessageFormBuilder;
use \FormBuilder\CommentFormBuilder;
use \Swift_SmtpTransport;
use \Swift_Mailer;
use \Swift_Message;

class PostController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
  	// Traitement du formulaire de contact si le formulaire a été envoyé.
  	if ($request->method() == 'POST')
  	{
        // Le formulaire a t-il été détourné ? (CSRF)
        if(!$this->formToken->checkFormToken($request))
        {
            $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
            $this->app->httpResponse()->redirect('/');
        }
        // Fin CSRF-----------------

        $message = new Message([
        	'firstName' =>  $request->postData('firstName'),
        	'lastName' =>   $request->postData('lastName'),
        	'email' =>      $request->postData('email'),
        	'message' =>    $request->postData('message')
        ]);

        $messageValide = true;
    }
    else
    {
  		$message = new Message;
    }

    // CSRF...
    $formtoken = $this->formToken->setFormToken();
    $message->setFormToken($formtoken);


	$formBuilder = new MessageFormBuilder($message);
	$formBuilder->build();

	$form = $formBuilder->form();

    if (isset($messageValide) && $messageValide)
    {
      $textMessage=
        $message->lastName()."\n".
        $message->firstName()."\n".
        $message->email()."\n".
        $message->message();

        // Recherche des paramètres
      $conf= Conf::getInstance();
      $mail_userAdress  = $conf->get('mail_userAdress');
      $mail_password    = $conf->get('mail_password');
      $mail_encryption  = $conf->get('mail_encryption');
      $mail_port        = $conf->get('mail_port');
      $mail_host        = $conf->get('mail_host');
      $mail_name        = $conf->get('mail_name');
      $mail_ident       = $conf->get('mail_ident');

      // Envoi du mail du formulaire
      $transport = (new Swift_SmtpTransport($mail_host, $mail_port, $mail_encryption))
      ->setUserName($mail_ident)
      ->setPassword($mail_password);

      $mailer = new Swift_Mailer($transport);

      $message = (new Swift_Message('Message du blog php'))
      ->setFrom([$message->email() => $message->lastName()])
      ->setTo([$mail_userAdress])
      ->setBody($textMessage);

      $mailer->send($message);

      $this->app->user()->setFlash('Le message a bien été envoyé, merci !');

      $this->app->httpResponse()->redirect('/');
    }

		$this->page->addVar('form', $form->createView());

		 // On ajoute une définition pour le titre.
		$this->page->addVar('title', 'Mon blog PHP');
  }

  public function executeShowPosts()
  {
    $nombrePosts = $this->app->config()->get('nombre_posts');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

    // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Liste des '.$nombrePosts.' derniers posts');

    // On récupère le manager des posts.
    $manager = $this->managers->getManagerOf('Post');
    $listePosts = $manager->getList(0, $nombrePosts);

    foreach ($listePosts as $post)
    {
      if (strlen($post->contenu()) > $nombreCaracteres)
      {
      	$debut = substr($post->contenu(), 0, $nombreCaracteres);
      	$debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

      	$post->setContenu($debut);
      }
    }
    // On ajoute la variable $liste à la vue.
    $this->page->addVar('listePosts', $listePosts);
  }

  public function executeShow(HTTPRequest $request)
  {
    $post = $this->managers->getManagerOf('Post')->getUnique($request->getData('id'));

    if (empty($post))
    {
      $this->app->httpResponse()->redirect404();
    }

    $this->page->addVar('title', $post->title());

    $this->page->addVar('post', $post);

    $state = 1; // State = 1, sont les commentaires validés
    $comments = $this->managers->getManagerOf('Comment')->getListOf($post->id(), $state);

    $this->page->addVar('comments', $comments);

    $userSession=$this->app->user()->getAttribute('users');

    if(isset($userSession))
    {
      $this->page->addVar('users', $userSession);
    }
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
        // Le formulaire a t-il été détourné ? (CSRF)
        if(!$this->formToken->checkFormToken($request))
        {
            $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
            $this->app->httpResponse()->redirect('/post-'.$request->getData('post_id').'.html');
        }
        // Fin CSRF-----------------

        $comment = new Comment([
        	'contenu'   =>  $request->postData('contenu'),
        	'post_id'   =>  $request->getData('post'),
        	'state'     =>  0,
        	'users_id'  =>  $_SESSION['users']->id(),
        ]);
    }
    else
    {
        $comment = new Comment;
    }

    // CSRF...
    $formtoken = $this->formToken->setFormToken();
    $comment->setFormToken($formtoken);

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comment'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');

      $this->app->httpResponse()->redirect('post-'.$request->getData('post').'.html');
    }

    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }

  public function executeUpdateComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un commentaire');

    if ($request->method() == 'POST')
    {
        // Le formulaire a t-il été détourné ? (CSRF)
        if(!$this->formToken->checkFormToken($request))
        {
            $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
            $this->app->httpResponse()->redirect('/post-'.$request->getData('post_id').'.html');
        }
        // Fin CSRF-----------------


        $comment = new Comment([
        	'id'      =>  $request->postData('id'),
        	'contenu' =>  $request->postData('contenu'),
        	'post_id' =>  $request->postData('post_id'),
        	'state'   =>  0,
        ]);
    }
    else
    {
        $comment = $this->managers->getManagerOf('Comment')->get($request->getData('id'));
    }

     // CSRF...
    $formtoken = $this->formToken->setFormToken();
    $comment->setFormToken($formtoken);

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comment'), $request);

    if ($formHandler->process())
    {
        $this->app->user()->setFlash('Le commentaire a bien été modifié');

        $this->app->httpResponse()->redirect('/post-'.$request->postData('post_id').'.html');
    }

    $this->page->addVar('form', $form->createView());
  }
}
