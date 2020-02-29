<?php
namespace Model;

use \Entity\Comment;

class CommentManagerPDO extends CommentManager
{
  protected function add(Comment $comment)
  {
   
    $requete = $this->dao->prepare('INSERT INTO comments SET contenu = :contenu, edition_date = NOW(), state = :state, users_id = :users_id, post_id = :post_id');

    $requete->bindValue(':contenu',     $comment->contenu());
    $requete->bindValue(':state',       0);
    $requete->bindValue(':users_id',    $comment->users_id());
    $requete->bindValue(':post_id',     $comment->post_id());

    $requete->execute();

    $comment->setId($this->dao->lastInsertId());
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM comments WHERE id = '.(int) $id);
  }

  public function deleteFromPost($postId)
  {
    $this->dao->exec('DELETE FROM comments WHERE post_id = '.(int) $postId);
  }
  
  public function deleteFromUsers($userId)
  {
    $this->dao->exec('DELETE FROM comments WHERE users_id = '.(int) $userId);
  }


  public function getListOf($postId, $state=1)
  {
    if (!ctype_digit($postId))
    {
      throw new \InvalidArgumentException('L\'identifiant du post passé doit être un nombre entier valide');
    }

    $requete = $this->dao->prepare('SELECT c.id, contenu, edition_date, state, users_id, post_id, u.login AS author_name '
            . 'FROM comments c '
            . 'INNER JOIN users u ON u.id = c.users_id '
            . 'WHERE post_id = :postid '
            . 'AND (state = 1 OR state = :state)');

    $requete->bindValue(':postid', $postId, \PDO::PARAM_INT);
    $requete->bindValue(':state',  $state, \PDO::PARAM_INT);

    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    $comments = $requete->fetchAll();

    foreach ($comments as $comment)
    {
      $comment->setEdition_date(new \DateTime($comment->edition_date()));
    }

    return $comments;
  }

  public function update(Comment $comment)
  {
    $requete = $this->dao->prepare('UPDATE comments SET contenu = :contenu, state = :state WHERE comments.id = :id');

    $requete->bindValue(':contenu', $comment->contenu());
    $requete->bindValue(':state',   $comment->state());

    $requete->bindValue(':id',      $comment->id());

    $requete->execute();
  }

  public function get($id)
  {
    $requete = $this->dao->prepare('SELECT c.id, contenu, edition_date, state, users_id, post_id, u.login AS author_name FROM comments c INNER JOIN users u ON c.users_id = u.id WHERE c.id = :id');

    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    return $requete->fetch();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
  }

  public function countUnvalidate()
  {
    return $this->dao->query('SELECT COUNT(*) FROM comments WHERE state = 0')->fetchColumn();
  }
}
