<?php
namespace App\Backend\Modules\Post;

use \Entity\Post;
use \Entity\Comment;
use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \OCFram\FormHandler;
use \FormBuilder\PostFormBuilder;
use \FormBuilder\CommentFormBuilder;

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

  public function executeShowPosts()
  {
    $this->page->addVar('title', 'Gestion des Articles');

    $manager = $this->managers->getManagerOf('Post');

    $this->page->addVar('listePosts', $manager->getList());
    $this->page->addVar('nombrePosts', $manager->count());
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
    $this->app->user()->setSession('postState', 'insert');

    $this->page->addVar('title', 'Ajout d\'un article');
  }

  public function executeUpdate(HTTPRequest $request)
  {
    $this->processForm($request);
    $this->app->user()->setSession('postState', 'update');

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
      //On vérifie la présence des  tokens (CSRF)
      if (!empty($_SESSION['formToken']) AND !empty($request->postData('formToken')))
      {
        // Le formulaire a t-il été détourné ?
        if($request->postData('formToken') != $_SESSION["formToken"])
        {
          $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
          $this->app->httpResponse()->redirect('/admin/post-show-'.$comment->post_id().'.html');
        }
      }
      else
      {
        $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
        $this->app->httpResponse()->redirect('/admin/post-show-'.$comment->post_id().'.html');
      }

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

    // CSRF...
    $formToken = bin2hex(random_bytes(20));
    $_SESSION['formToken'] = $formToken;

    $comment-> setFormToken($formToken);

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
      // Le formulaire a t-il été détourné ? (CSRF)
      //On vérifie la présence des  tokens
      if (!empty($_SESSION['formToken']) AND !empty($request->postData('formToken')))
      {
        if($request->postData('formToken') != $_SESSION["formToken"])
        {
          $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
          $this->app->httpResponse()->redirect('/admin/posts.html');
        }
      }
      else
      {
        $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
        $this->app->httpResponse()->redirect('/connect.html');
      }
      //---------------------Fin CSFR-----------------------

      $users = $this->app->user()->getAttribute('users');

      $post = new Post([
        'id'            => $request->postData('id'),
        'name'          => $request->postData('name'),
        'title'         => $request->postData('title'),
        'chapo'         => $request->postData('chapo'),
        'contenu'       => $request->postData('contenu'),
        'users_id'      => $users->id(),

      ]);
    }
    else
    {
      // L'identifiant du post est transmis en cas de modification
      if ($request->getExists('id'))
      {
        $post = $this->managers->getManagerOf('Post')->getUnique($request->getData('id'));
      }
      else // Sinon c'est une création de post
      {
        $post = new Post;
      }
    }

    // CSRF...
    $formToken = bin2hex(random_bytes(20));
    $_SESSION['formToken'] = $formToken;

    $post->setFormToken($formToken);

    $formBuilder = new PostFormBuilder($post);
    $formBuilder->build();

    $form = $formBuilder->form();

    $formHandler = new FormHandler($form, $this->managers->getManagerOf('Post'), $request);

    if ($formHandler->process())
    {
      if($this->app->user()->getAttribute('postState') == 'insert')
      {
        $this->app->user()->setFlash('L\'article a bien été ajouté !');
      }
      elseif($this->app->user()->getAttribute('postState') == 'update')
      {
        $this->app->user()->setFlash('L\'article a bien été modifié !');
      }

      $this->app->httpResponse()->redirect('/admin/posts.html');
    }

    $this->page->addVar('form', $form->createView());
  }

  public function executeInsertComment(HTTPRequest $request)
  {
    // Si le formulaire a été envoyé.
    if ($request->method() == 'POST')
    {
      // Le formulaire a t-il été détourné ? (CSRF)
      //On vérifie la présence des  tokens
      if (!empty($_SESSION['formToken']) AND !empty($request->postData('formToken')))
      {
        if($request->postData('formToken') != $_SESSION["formToken"])
        {
          $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
          $this->app->httpResponse()->redirect('/admin/post-show-'.$request->getData('post').'.html');
        }
      }
      else
      {
        $this->app->user()->setFlash('Le formulaire n\'est pas valide, merci de réessayer.');
        $this->app->httpResponse()->redirect('/admin/post-show-'.$request->getData('post').'.html');
      }

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
    $formToken = bin2hex(random_bytes(20));
    $_SESSION['formToken'] = $formToken;

    $comment->setFormToken($formToken);

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



