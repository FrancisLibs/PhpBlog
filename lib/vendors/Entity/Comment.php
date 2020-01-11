<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $id,
            $contenu,
            $edition_date,
            $state,
            $user_id,
            $post_id;


  const CONTENU_INVALIDE = 1;

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

    $this->contenu = $contenu;
  }

  public function setEdition_date(\DateTime $edition_date)
  {
    $this->edition_date = $edition_date;
  }

  public function setState($state)
  {
    $this->state = $state;
  }

  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;
  }

  public function setPost_id($post_id)
  {
    $this->post_id = $post_id;
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

  public function user_id()
  {
    return $this->user_id;
  }

  public function post_id()
  {
    return $this->post_id;
  }
}
