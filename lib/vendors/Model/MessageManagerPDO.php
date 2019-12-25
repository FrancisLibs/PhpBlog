<?php
namespace Model;

use \Entity\Post;

class ContactManagerPDO extends MessageManager
{
  protected function add(Message $message)
  {
    $q = $this->dao->prepare('INSERT INTO messages SET name = :name, email = :email, message = :message, edition_date = NOW()');

    $q->bindValue(':name',   $message->name());
    $q->bindValue(':email',  $message->email());
    $q->bindValue(':contents', $message->contents());
    $q->bindValue(':edition_date',   $message->edition_date());

    $q->execute();

    $message->setId($this->dao->lastInsertId());
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM messages WHERE id = '.(int) $id);
  }

  public function getList()
  {

    $sql = 'SELECT id, author, title, chapo, contents, edition_date, modify_date FROM messages ORDER BY id DESC';

    $requete = $this->dao->query($sql);

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Message');

    $listeMessages = $requete->fetchAll();


    foreach ($listeMessages as $message)
    {
      $message->setEdition_date(new \DateTime($message->edition_date()));
    }

    $requete->closeCursor();

    return $listeMessages;
  }

  public function getUnique($id)
  {
    $requete = $this->dao->prepare('SELECT id, name, email, message, edition_date FROM messages WHERE id = :id');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Message');

    if ($message = $requete->fetch())
    {
      $message->setEdition_date(new \DateTime($message->edition_date()));

      return $message;
    }

    return null;
  }
}
