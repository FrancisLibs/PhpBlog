<?php
namespace Entity;

use \OCFram\Entity;

class Post extends Entity
{
  protected $author,
            $title,
            $chapo,
            $contents,
            $edition_date,
            $modify_date;

  const AUTEUR_INVALIDE = 1;
  const TITRE_INVALIDE = 2;
  const CHAPO_INVALIDE = 3;
  const CONTENU_INVALIDE = 4;

  public function isValid()
  {
    return !(empty($this->author) || empty($this->title) || empty($this->chapo) || empty($this->contents));
  }


  // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->auteur = $author;
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

  public function setContents($contents)
  {
    if (!is_string($contents) || empty($contents))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

    $this->contents = $contents;
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

  public function auteur()
  {
    return $this->auteur;
  }

  public function title()
  {
    return $this->title;
  }

  public function chapo()
  {
    return $this->chapo;
  }

  public function contents()
  {
    return $this->contents;
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
