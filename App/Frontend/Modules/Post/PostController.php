<?php
namespace App\Frontend\Modules\Post;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\MessageFormBuilder;
use \OCFram\FormHandler;
use \Entity\Message;
use DateTime;



class PostController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    // Traitement du formulaire de message si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Message([
        'firstName' =>  $request->postData('firstName'),
        'lastName' =>   $request->postData('lastName'),
        'email' =>      $request->postData('email'),
        'message' =>    $request->postData('message')
      ]);
    }
    else
    {
      $message = new Message;
    }

    $formBuilder = new MessageFormBuilder($message);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Message'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le message a bien été envoyé, merci !');

      $this->app->httpResponse()->redirect('post-'.$request->getData('post').'.html');
    }

    $this->page->addVar('message', $message);
    $this->page->addVar('form', $form->createView());


     // On ajoute une définition pour le titre.
    $this->page->addVar('title', 'Mon blog PHP');

    $nombrePosts = $this->app->config()->get('nombre_posts');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

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

  public function executeShowPosts(HTTPRequest $request)
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

    $comments = $this->managers->getManagerOf('Comment')->getListOf($post->id());

    $this->page->addVar('comments', $comments);
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $date = new DateTime();
      $comment = new Comment([
        'contenu' =>  $request->postData('contenu'),
        'edition_date' => $date,
        'modify_date' =>  $date,
        'status'  =>  '1',
      ]);
    }
    else
    {
      $comment = new Comment;
    }

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
}
