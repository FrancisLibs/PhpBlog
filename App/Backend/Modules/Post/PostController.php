<?php
namespace App\Backend\Modules\Post;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Post;
use \FormBuilder\PostFormBuilder;
use \OCFram\FormHandler;

class PostController extends BackController
{
  public function executeIndex()
  {
    $this->page->addVar('title', 'Administration blog');
  }

  public function executeShowPosts(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des posts');

    $manager = $this->managers->getManagerOf('Post');

    $this->page->addVar('listePosts', $manager->getList());
    $this->page->addVar('nombrePosts', $manager->count());
    $this->page->addVar('nombreCommentairesInvalides', $manager->countUnvalidateComments());
  }

  public function executeDelete(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 3)
    {
        $this->app->user()->setFlash('Pour effacer des posts, il faut être superAdministrateur.');
        $this->app->httpResponse()->redirect('/.html');
    }
    
    $postId = $request->getData('id');

    $this->managers->getManagerOf('Comment')->deleteFromPost($postId);
    $this->managers->getManagerOf('Post')->delete($postId);

    $this->app->user()->setFlash('Le post a bien été supprimé !');

    $this->app->httpResponse()->redirect('posts.html');
  }

  public function executeDeleteComment(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 2)
    {
        $this->app->user()->setFlash('Pour effacer un commentaire, il faut être administrateur.');
        $this->app->httpResponse()->redirect('/.html');
    }
    
    $this->managers->getManagerOf('Comment')->delete($request->getData('id'));

    $this->app->user()->setFlash('Le commentaire a bien été supprimé !');

    $this->app->httpResponse()->redirect('.');
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

    $state = 0;
    $comments = $this->managers->getManagerOf('Comment')->getListOf($post->id(), $state);

    $this->page->addVar('comments', $comments);
  }

  public function executeInsert(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 2)
    {
        $this->app->user()->setFlash('Pour ajouter un post, il faut être administrateur.');
        $this->app->httpResponse()->redirect('/.html');
    }
      
    $this->processForm($request);

    $this->page->addVar('title', 'Ajout d\'un post');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 2)
    {
        $this->app->user()->setFlash('Pour modifier un post, il faut être administrateur.');
        $this->app->httpResponse()->redirect('/.html');
    }
    
    $this->processForm($request);

    $this->page->addVar('title', 'Modification d\'un post');
  }

  public function executeModerateComment(HTTPRequest $request)
  {
    // Gestion des droits
    $userSession=$this->app->user()->getAttribute('users');
    if($userSession->role()< 2)
    {
        $this->app->user()->setFlash('Pour valider un commentaire, il faut être administrateur.');
        $this->app->httpResponse()->redirect('/.html');
    }
    
    $manager = $this->managers->getManagerOf('Comment');
    $comment = $manager->get($request->getData('id'));
    $comment->setState(1);

    $manager->update($comment);

    $this->app->httpResponse()->redirect("post-show-". $comment->post_id().'.html');
  }

  public function processForm(HTTPRequest $request)
  {
    if ($request->method() == 'POST')
    {
      $users = $this->app->user()->getAttribute('users');

      $post = new Post([
        'id'            => $request->postData('id'),
        'name'          => $request->postData('name'),
        'title'         => $request->postData('title'),
        'chapo'         => $request->postData('chapo'),
        'contenu'       => $request->postData('contenu'),
        'users_id'       => $users->id(),
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

      $this->app->httpResponse()->redirect('/admin/posts.html');
    }
    
    $this->page->addVar('form', $form->createView());
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    $this->app->httpResponse()->redirect('/commenter-'. $_GET['post'].'.html');
  }
}



