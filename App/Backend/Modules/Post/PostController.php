<?php
namespace App\Backend\Modules\Post;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Post;
use \Entity\Comment;
use \FormBuilder\CommentFormBuilder;
use \FormBuilder\PostFormBuilder;
use \OCFram\FormHandler;

class PostController extends BackController
{
  public function executeDelete(HTTPRequest $request)
  {
    $postId = $request->getData('id');

    $this->managers->getManagerOf('Comment')->deleteFromPost($postId);
    $this->managers->getManagerOf('Post')->delete($postId);

    $this->app->user()->setFlash('Le post a bien été supprimé !');

    $this->app->httpResponse()->redirect('.');
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comment')->delete($request->getData('id'));

    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');

    $this->app->httpResponse()->redirect('.');
  }

  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des posts');

    $manager = $this->managers->getManagerOf('Post');

    $this->page->addVar('listePosts', $manager->getList());
    $this->page->addVar('nombrePosts', $manager->count());
  }

  public function executeInsert(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Ajout d\'un post');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);

    $this->page->addVar('title', 'Modification d\'un post');
  }

  public function executeUpdateComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un commentaire');

    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'id' => $request->getData('id'),
        'author' => $request->postData('author'),
        'contents' => $request->postData('contents')
      ]);
    }
    else
    {
      $comment = $this->managers->getManagerOf('Comment')->get($request->getData('id'));
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comment'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été modifié');

      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function processForm(HTTPRequest $request)
  {
    if ($request->method() == 'POST')
    {
      var_dump($request->postData('edition_date'));
      $post = new Post([
        'id'  =>  $request->postData('id'),
        'name' => $request->postData('name'),
        'title' => $request->postData('title'),
        'chapo' => $request->postData('chapo'),
        'contenu' => $request->postData('contenu'),

      ]);

      if ($request->getExists('id'))
      {
        $post->setId($request->getData('id'));
      }
    }
    else
    {
      // L'identifiant du post est transmis si on veut le modifier
      if ($request->getExists('id'))
      {
        $post = $this->managers->getManagerOf('Post')->getUnique($request->getData('id'));
      }
      else
      {
        $post = new Post;
      }
    }

    $formBuilder = new PostFormBuilder($post);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Post'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash($post->isNew() ? 'Le post a bien été ajouté !' : 'Le Post a bien été modifié !');

      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }
}
