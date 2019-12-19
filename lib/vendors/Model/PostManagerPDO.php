<?php
namespace Model;

use \Entity\Post;

class PostManagerPDO extends PostManager
{
  protected function add(Post $post)
  {
    $requete = $this->dao->prepare('INSERT INTO post SET author = :author, title = :title, chapo = :chapo, contents = :contents, edition_date = NOW(), modify_date = NOW()');

    $requete->bindValue(':title',   $post->title());
    $requete->bindValue(':author',  $post->author());
    $requete->bindValue(':chapo',   $post->chapo());
    $requete->bindValue(':contents', $post->contents());

    $requete->execute();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM post')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM post WHERE id = '.(int) $id);
  }

  public function getList($debut = -1, $limite = -1)
  {

    $sql = 'SELECT id, author, title, chapo, contents, edition_date, modify_date FROM post ORDER BY id DESC';

    if ($debut != -1 || $limite != -1)
    {
      $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }

    $requete = $this->dao->query($sql);

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Post');

    $listePosts = $requete->fetchAll();


    foreach ($listePosts as $post)
    {
      $post->setEdition_date(new \DateTime($post->edition_date()));
      $post->setModify_date(new \DateTime($post->modify_date()));
    }

    $requete->closeCursor();

    return $listePosts;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, author, title, chapo, contents, edition_date, modify_date FROM post WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Post');

    if ($post = $requete->fetch())
    {
      $post->setEdition_date(new \DateTime($post->edition_date()));
      $post->setModify_date(new \DateTime($post->modify_date()));

      return $post;
    }

    return null;
  }

  protected function modify(Post $post)
  {
    $requete = $this->dao->prepare('UPDATE post SET author = :author, title = :title, chapo = :chapo, contents = :contents, modify_date = NOW() WHERE id = :id');

    $requete->bindValue(':title',   $post->title());
    $requete->bindValue(':author',  $post->author());
    $requete->bindValue(':chapo',   $post->chapo());
    $requete->bindValue(':contents', $post->contents());
    $requete->bindValue(':id',      $post->id(), \PDO::PARAM_INT);

    $requete->execute();
  }
}
