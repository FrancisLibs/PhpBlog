<?php
namespace Model;

use \Entity\Comment;

class CommentsManagerPDO extends CommentsManager
{
  protected function add(Comment $comment)
  {
    $q = $this->dao->prepare('INSERT INTO comments SET contents = :contents, edition_date = NOW(), status = :status, userId = :userId, postId = :postId');

    $q->bindValue(':contents',  $comment->contents());
    $q->bindValue(':status',    $comment->status());
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

    $q = $this->dao->prepare('SELECT contenu, edition_date, modify_date, validity, name FROM comments INNER JOIN users ON comments.user_id = users.id WHERE post_id = :postId');

    $q->bindValue(':postId', $postId, \PDO::PARAM_INT);
    $q->execute();

    $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Comment');

    $comments = $q->fetchAll();

    foreach ($comments as $comment)
    {
      $comment->setEdition_date(new \DateTime($comment->edition_date()));
      $comment->setModify_date(new \DateTime($comment->modify_date()));
    }

    return $comments;
  }

  protected function modify(Comment $comment)
  {
    $q = $this->dao->prepare('UPDATE comments SET auteur = :auteur, contenu = :contenu WHERE id = :id');

    $q->bindValue(':auteur', $comment->author());
    $q->bindValue(':contents', $comment->contents());
    $q->bindValue(':id', $comment->id(), \PDO::PARAM_INT);

    $q->execute();
  }

  public function get($id)
  {
    $q = $this->dao->prepare('SELECT id, post, author, contents FROM comments WHERE id = :id');
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
    return $this->dao->query('SELECT COUNT(*) FROM comments WHERE status = ""')->fetchColumn();
  }
}
