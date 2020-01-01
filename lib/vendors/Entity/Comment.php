<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $id,
            $contenu,
            $edition_date,
            $modify_date,
            $status,
            $name,
            $post;

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

  public function setModify_date(\DateTime $modify_date)
  {
    $this->modify_date = $modify_date;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setPost($post)
  {
    $this->post = $post;
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

  public function modify_date()
  {
    return $this->modify_date;
  }

  public function satus()
  {
    return $this->status;
  }

  public function name()
  {
    return $this->name;
  }

  public function post()
  {
    return $this->post;
  }
}
