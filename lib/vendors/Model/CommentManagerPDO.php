<?php
namespace Model;

use \Entity\Comment;

class CommentManagerPDO extends CommentManager
{
  protected function add(Comment $comment)
  {
    $q = $this->dao->prepare('INSERT INTO comments SET contenu = :contenu, edition_date = NOW(), state = :state, userId = :userId, postId = :postId');

    $q->bindValue(':contenu',   $comment->contenu());
    $q->bindValue(':state',     '0');
    $q->bindValue(':userId',    $comment->userId());
    $q->bindValue(':postId',    $comment->postId());

    $q->execute();

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

  public function getListOf($postId)
  {
    if (!ctype_digit($postId))
    {
      throw new \InvalidArgumentException('L\'identifiant du post passé doit être un nombre entier valide');
    }

    $q = $this->dao->prepare('SELECT id, contenu, edition_date, state, user_id, post_id FROM comments WHERE post_id = :postId');

    $q->bindValue(':postId', $postId, \PDO::PARAM_INT);
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    $comments = $q->fetchAll();

    foreach ($comments as $comment)
    {
      $comment->setEdition_date(new \DateTime($comment->edition_date()));
    }

    return $comments;
  }

  protected function modify(Comment $comment)
  {
    $q = $this->dao->prepare('UPDATE comments SET contenu = :contenu WHERE id = :id');

    $q->bindValue(':contenu', $comment->contenu());
    $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

    $q->execute();
  }

  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, post, author, contenu FROM comments WHERE id = :id');
    $q->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    return $q->fetch();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM comments')->fetchColumn();
  }

  public function countUnvalidate()
  {
    return $this->dao->query('SELECT COUNT(*) FROM comments WHERE state = ""')->fetchColumn();
  }
}
