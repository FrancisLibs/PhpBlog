<?php
namespace Model;

use \Entity\Post;

class PostManagerPDO extends PostManager
{
  protected function add(Post $post)
  {
    $q = $this->dao->prepare('INSERT INTO posts SET author = :author, title = :title, chapo = :chapo, contenu = :contenu, edition_date = NOW(), modify_date = NOW()');

    $q->bindValue(':title',   $post->title());
    $q->bindValue(':author',  $post->author());
    $q->bindValue(':chapo',   $post->chapo());
    $q->bindValue(':contenu', $post->contenu());

    $q->execute();

    $post->setId($this->dao->lastInsertId());
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

    $sql = 'SELECT posts.id, users.name, title, chapo, contenu, edition_date, modify_date FROM posts INNER JOIN users ON posts.users_id = users.id ORDER BY id DESC';

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
    $requete = $this->dao->prepare('SELECT posts.id, users.name, title, chapo, contenu, edition_date, modify_date FROM posts INNER JOIN users ON posts.users_id = users.id WHERE posts.id = :id');

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

  protected function update(Post $post)
  {
    $requete = $this->dao->prepare('UPDATE posts SET name = :name, title = :title, chapo = :chapo, contenu = :contenu, modify_date = NOW() WHERE id = :id');

    $requete->bindValue(':title',   $post->title());
    $requete->bindValue(':name',    $post->name());
    $requete->bindValue(':chapo',   $post->chapo());
    $requete->bindValue(':contenu', $post->contenu());
    $requete->bindValue(':id',      $post->id(), \PDO::PARAM_INT);

    $requete->execute();
  }
}
