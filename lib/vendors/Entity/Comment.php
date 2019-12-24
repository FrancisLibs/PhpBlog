<?php
namespace Entity;

use \OCFram\Entity;

class Comment extends Entity
{
  protected $post,
            $author,
            $contents,
            $edition_date,
            $status;

  const AUTEUR_INVALIDE = 1;
  const CONTENU_INVALIDE = 2;

  public function isValid()
  {
    return !(empty($this->auteur) || empty($this->contenu));
  }
   // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setPost($news)
  {
    $this->news = (int) $news;
  }

  public function setAuthor($author)
  {
    if (!is_string($author) || empty($author))
    {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    }

    $this->author = $author;
  }

  public function setContents($contenu)
  {
    if (!is_string($contenu) || empty($contenu))
    {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    }

    $this->contents = $contenu;
  }

  public function setEditionDate(\DateTime $date)
  {
    $this->edition_date = $date;
  }

  public function setModifyDate(\DateTime $date)
  {
    $this->modify_date = $date;
  }

  public function post()
  {
    return $this->post;
  }

  public function auteur()
  {
    return $this->auteur;
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
