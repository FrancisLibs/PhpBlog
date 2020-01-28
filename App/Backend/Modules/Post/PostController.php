<?php
namespace App\Backend\Modules\Post;

use \Entity\Post;
use \Entity\Comment;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;
use \FormBuilder\PostFormBuilder;
use \FormBuilder\CommentFormBuilder;
use \Model\CommentManagerPDO;


class PostController extends BackController
{
  public function executeIndex()
  {
    if(!$this->app->user()->isAuthenticated())
    {
        $this->app->user()->setFlash('Merci de vous connecter');
        $this->app->httpResponse()->redirect('/');
    }
    
    $this->page->addVar('title', 'Administration blog');
  }

  public function executeShowPosts(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Gestion des Articles');

    $manager = $this->managers->getManagerOf('Post');

    $this->page->addVar('listePosts', $manager->getList());
    $this->page->addVar('nombrePosts', $manager->count());
    $this->page->addVar('nombreCommentairesInvalides', $manager->countUnvalidateComments());
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
    $this->processForm($request);

    $this->page->addVar('title', 'Ajout d\'un post');
  }

  public function executeUpdate(HTTPRequest $request)
  {  
    $this->processForm($request);

    $this->page->addVar('title', 'Modification d\'un article');
  }

  public function executeDelete(HTTPRequest $request)
  {
    $postId = $request->getData('id');
    
    $this->managers->getManagerOf('Comment')->deleteFromPost($postId);
    $this->managers->getManagerOf('Post')->delete($postId);
    
    $this->app->user()->setFlash('L\'article a bien été supprimé ! ');

    $this->app->httpResponse()->redirect('/admin/posts.html');
  }

  public function executeValidateComment(HTTPRequest $request)
  {
    $manager = $this->managers->getManagerOf('Comment');
    $comment = $manager->get($request->getData('id'));
    $comment->setState(1);

    $manager->update($comment);

    $this->app->httpResponse()->redirect('/admin/post-show-'.$comment->post_id().'.html');
   
  }

  public function executeUpdateComment(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Modification d\'un commentaire');

    if ($request->method() == 'POST')
    {
      $comment = new Comment([
        'contenu' => $request->postData('contenu'),
        'post_id' => $request->postData('post_id'),
        'state'   =>  0,
        'id'      => $request->postData('id'),
      ]);
    }
    else
    {
      $manager = $this->managers->getManagerOf('Comment');

      $comment = $manager->get($request->getData('id'));
    }

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comment'), $request);
    
    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été modifié');

      $this->app->httpResponse()->redirect("post-show-". $comment->post_id().'.html');
    }

    $this->page->addVar('form', $form->createView());
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
        'users_id'      => $users->id(),

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
      $this->app->user()->setFlash($post->isNew() ? 'L\'article a bien été ajouté !' : 'L\'article a bien été modifié !');

      $this->app->httpResponse()->redirect('/admin/posts.html');
    }
    
    $this->page->addVar('form', $form->createView());
  }

  public function executeInsertComment(HTTPRequest $request)
  {  
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
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

    $formBuilder = new CommentFormBuilder($comment);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Comment'), $request);

    if ($formHandler->process())
    {
      $this->app->user()->setFlash('Le commentaire a bien été ajouté, merci !');

      $this->app->httpResponse()->redirect('/admin/post-show-'.$request->getData('post').'.html');
    }

    $this->page->addVar('comment', $comment);
    $this->page->addVar('form', $form->createView());
    $this->page->addVar('title', 'Ajout d\'un commentaire');
  }
  
  public function executeRefuseComment(HTTPRequest $request)
  {   
    $manager = $this->managers->getManagerOf('Comment');
    $comment = $manager->get($request->getData('id'));
    $comment->setState(2);

    $manager->update($comment);

    $this->app->httpResponse()->redirect('/admin/post-show-'.$comment->post_id().'.html');
  }
}



