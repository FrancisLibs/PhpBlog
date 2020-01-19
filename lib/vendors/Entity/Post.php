<?php
namespace Entity;

use \OCFram\Entity;

class Post extends Entity
{
  protected $id,
            $title,
            $chapo,
            $contenu,
            $edition_date,
            $update_date,
            $author_name,
            $users_id;


  const AUTEUR_INVALIDE = 1;
  const TITRE_INVALIDE = 2;
  const CHAPO_INVALIDE = 3;
  const CONTENU_INVALIDE = 4;

  public function isValid()
  {
    return !(empty($this->title) || empty($this->chapo) || empty($this->contenu));
  }


  // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setTitle($title)
  {
    if (!is_string($title) || empty($title))
    {
      $this->erreurs[] = self::TITRE_INVALIDE;
    }

    $this->title = $title;
  }

  public function setChapo($chapo)
  {
    if (!is_string($chapo) || empty($chapo))
    {
      $this->erreurs[] = self::CHAPO_INVALIDE;
    }

    $this->chapo = $chapo;
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

  public function setUpdate_date(\DateTime $update_date)
  {
    $this->update_date = $update_date;
  }

  public function setAuthor_Name($author_name)
  {
    if (!is_string($author_name) || empty($author_name))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->author_name = $author_name;
  }

   public function setUsers_id($users_id)
  {
    $this->users_id = $users_id;
  }


  // GETTERS //

  public function id()
  {
    return $this->id;
  }

  public function title()
  {
    return $this->title;
  }

  public function chapo()
  {
    return $this->chapo;
  }

  public function contenu()
  {
    return $this->contenu;
  }

  public function edition_date()
  {
    return $this->edition_date;
  }

  public function update_date()
  {
    return $this->update_date;
  }

  public function author_name()
  {
    return $this->author_name;
  }

   public function users_id()
  {
    return $this->users_id;
  }
}
