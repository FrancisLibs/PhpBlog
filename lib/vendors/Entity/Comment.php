<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $id,
            $contenu,
            $edition_date,
            $state,
            $users_id,
            $post_id,
            $author_name;


  const CONTENU_INVALIDE = 1;
  const AUTEUR_INVALIDE = 1;

  public function isValid()
  {
    return !empty($this->contenu);
  }

   // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setContenu($contenu)
  {
    if (!is_string($contenu) || empty($contenu))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

    $this->contenu = htmlentities($contenu);
  }

  public function setEdition_date(\DateTime $edition_date)
  {
    $this->edition_date = $edition_date;
  }

  public function setState($state)
  {
    $this->state = htmlentities($state);
  }

  public function setUsers_id($users_id)
  {
    $this->users_id = htmlentities($users_id);
  }

  public function setPost_id($post_id)
  {
    $this->post_id = htmlentities($post_id);
  }

  public function setAuthor_name($author_name)
  {
    if (!is_string($author_name) || empty($author_name))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->author_name = htmlentities($author_name);
  }

  public function id()
  {
    return $this->id;
  }

  public function contenu()
  {
    return $this->contenu;
  }

  public function edition_date()
  {
    return $this->edition_date;
  }

  public function state()
  {
    return $this->state;
  }

  public function users_id()
  {
    return $this->users_id;
  }

   public function post_id()
  {
    return $this->post_id;
  }

  public function author_name()
  {
    return $this->author_name;
  }
}
