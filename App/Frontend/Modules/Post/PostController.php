<?php
namespace App\Frontend\Modules\Post;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Comments;
use \FormBuilder\CommentsFormBuilder;
use \OCFram\FormHandler;

class PostController extends BackController
{
  public function executeIndex(HTTPRequest $request)
  {
    $nombrePosts = $this->app->config()->get('nombre_posts');
    $nombreCaracteres = $this->app->config()->get('nombre_caracteres');

    // On informe le layout que c'est la page d'accueil
    $this->page->addVar('accueil', true);

    // On récupère le manager des posts.
    $manager = $this->managers->getManagerOf('Post');

    $listePosts = $manager->getList(0, $nombrePosts);


    foreach ($listePosts as $post)
    {
      if (strlen($post->contents()) > $nombreCaracteres)
      {
        $debut = substr($post->contents(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

        $post->setContents($debut);
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
      if (strlen($post->contents()) > $nombreCaracteres)
      {
        $debut = substr($post->contents(), 0, $nombreCaracteres);
        $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

        $post->setContents($debut);
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

    $this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($post->id()));
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'post' => $request->getData('post'),
        'author' => $request->postData('author'),
        'contents' => $request->postData('contents')
      ]);
    }
    else
    {
      $comment = new Comment;
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

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
