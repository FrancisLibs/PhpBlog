<?php
namespace Model;

use \Entity\Posts;

class PostsManagerPDO extends PostManager
{
  protected function add(Posts $post)
  {
    $requete = $this->dao->prepare('INSERT INTO posts SET auteur = :auteur, titre = :titre, chapo = :chapo, contenu = :contenu, dateAjout = NOW(), dateModif = NOW()');

    $requete->bindValue(':titre', $posts->titre());
    $requete->bindValue(':auteur', $posts->auteur());
    $requete->bindValue(':chapo', $posts->chapo());
    $requete->bindValue(':contenu', $posts->contenu());

    $requete->execute();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM posts')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM posts WHERE id = '.(int) $id);
  }

  public function getList($debut = -1, $limite = -1)
  {
    $sql = 'SELECT id, auteur, titre, chapo, contenu, dateAjout, dateModif FROM posts ORDER BY id DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);
    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Posts');

    $listePosts = $requete->fetchAll();

    foreach ($listePosts as $posts)
    {
      $posts->setDateAjout(new \DateTime($posts->dateAjout()));
      $posts->setDateModif(new \DateTime($posts->dateModif()));
    }

    $requete->closeCursor();

    return $listePosts;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, auteur, titre, chapo, contenu, dateAjout, dateModif FROM posts WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Posts');

    if ($posts = $requete->fetch())
    {
      $posts->setDateAjout(new \DateTime($posts->dateAjout()));
      $posts->setDateModif(new \DateTime($posts->dateModif()));

      return $posts;
    }

    return null;
  }

  protected function modify(Posts $posts)
  {
    $requete = $this->dao->prepare('UPDATE posts SET auteur = :auteur, titre = :titre, chapo = :chapo, contenu = :contenu, dateModif = NOW() WHERE id = :id');

    $requete->bindValue(':titre', $posts->titre());
    $requete->bindValue(':auteur', $posts->auteur());
    $requete->bindValue(':chapo', $posts->chapo());
    $requete->bindValue(':contenu', $posts->contenu());
    $requete->bindValue(':id', $posts->id(), \PDO::PARAM_INT);

    $requete->execute();
  }
}
