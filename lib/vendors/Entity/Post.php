<?php
namespace Entity;

use \OCFram\Entity;

class Post extends Entity
{
  protected $name,
            $title,
            $chapo,
            $contenu,
            $edition_date,
            $modify_date;

  const AUTEUR_INVALIDE = 1;
  const TITRE_INVALIDE = 2;
  const CHAPO_INVALIDE = 3;
  const CONTENU_INVALIDE = 4;

  public function isValid()
  {
    return !(empty($this->author) || empty($this->title) || empty($this->chapo) || empty($this->contenu));
  }


  // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setName($name)
  {
    if (!is_string($name) || empty($name))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->name = $name;
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

  public function setModify_date(\DateTime $modify_date)
  {
    $this->modify_date = $modify_date;
  }

  // GETTERS //

  public function name()
  {
    return $this->name;
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

  public function modify_date()
  {
    return $this->modify_date;
  }
}
