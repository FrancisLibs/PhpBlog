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

    $this->managers->getManagerOf('Post')->delete($postId);
    $this->managers->getManagerOf('Comments')->deleteFromPost($postId);

    $this->app->user()->setFlash('Le post a bien été supprimé !');

    $this->app->httpResponse()->redirect('.');
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    $this->managers->getManagerOf('Comments')->delete($request->getData('id'));

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
      $comment = $this->managers->getManagerOf('Comments')->get($request->getData('id'));
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comments'), $request);

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
      $post = new Post([
        'author' => $request->postData('author'),
        'title' => $request->postData('title'),
        'contents' => $request->postData('contents')
      ]);

      if ($request->getExists('id'))
      {
        $news->setId($request->getData('id'));
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

    $formBuilder = new NewsFormBuilder($post);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Post'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash($news->isNew() ? 'La news a bien été ajoutée !' : 'La news a bien été modifiée !');

      $this->app->httpResponse()->redirect('/admin/');
    }

    $this->page->addVar('form', $form->createView());
  }
}
