<?php
namespace Model;

use \Entity\Post;

class PostManagerPDO extends PostManager
{
  protected function add(Post $post)
  {
    $q = $this->dao->prepare('INSERT INTO posts SET title = :title, chapo = :chapo, contenu = :contenu, edition_date = NOW(), update_date = NOW(), user_id = :user_id');

    $q->bindValue(':title',   $post->title());
    $q->bindValue(':chapo',   $post->chapo());
    $q->bindValue(':contenu', $post->contenu());
    $q->bindValue(':user_id', '1');

    $q->execute();

    $post->setId($this->dao->lastInsertId());
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM posts')->fetchColumn();
  }

  public function countUnvalidateComments()
  {
    return $this->dao->query('SELECT COUNT(c.id) FROM posts p INNER JOIN comments c ON p.id = c.post_id WHERE c.state = 0')->fetchColumn();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM posts WHERE id = '.(int) $id);
  }

  public function getList($debut = -1, $limite = -1)
  {

<<<<<<< HEAD
    $sql = 'SELECT posts.id, title, chapo, contenu, edition_date, update_date, user_id, users.login AS autor_name FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC';
=======
    $sql = 'SELECT posts.id, title, chapo, contenu, edition_date, update_date, user_id, users.name AS autor_name FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC';
>>>>>>> b0dc17c6d35e97827f8f90458d25094c73454f04

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
      $post->setUpdate_date(new \DateTime($post->update_date()));
    }

    $requete->closeCursor();

    return $listePosts;
  }

  public function getUnique($id)
  {
<<<<<<< HEAD
    $requete = $this->dao->prepare('SELECT posts.id, title, chapo, contenu, edition_date, update_date, user_id, users.login AS autor_name FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :id');
=======
    $requete = $this->dao->prepare('SELECT posts.id, title, chapo, contenu, edition_date, update_date, user_id, users.name AS autor_name FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :id');
>>>>>>> b0dc17c6d35e97827f8f90458d25094c73454f04

    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Post');

    if ($post = $requete->fetch())
    {
      $post->setEdition_date(new \DateTime($post->edition_date()));
      $post->setUpdate_date(new \DateTime($post->update_date()));

      return $post;
    }

    return null;
  }

  protected function update(Post $post)
  {
    $requete = $this->dao->prepare('UPDATE posts SET title = :title, chapo = :chapo, contenu = :contenu, update_date = NOW(), user_id = :user_id WHERE id = :id');

    $requete->bindValue(':title',   $post->title());
    $requete->bindValue(':chapo',   $post->chapo());
    $requete->bindValue(':contenu', $post->contenu());
    $requete->bindValue(':id', $post->id());
    $requete->bindValue(':user_id', '1');

    $requete->execute();
  }
}
