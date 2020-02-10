<?php
namespace Model;

use \Entity\Message;

class MessageManagerPDO extends MessageManager
{
  protected function add(Message $message)
  {
    $requete = $this->dao->prepare('INSERT INTO messages SET firstName = :firstName, lastName = :lastName, email = :email,  edition_date = NOW(), message= :message');

    $requete->bindValue(':firstName',     $user->firstName());
    $requete->bindValue(':lastName',  $user->lastName());
    $requete->bindValue(':email',     $user->emailr());
    $requete->bindValue(':message',     $user->message());

    $requete->execute();
  }

  protected function update(Message $message)
  {
    $requete = $this->dao->prepare('UPDATE messages SET firstName = :firstName, lastName = :lastName, email = :email, modify_date = NOW(), message = :message WHERE id = :id');

    $requete->bindValue(':id',        $user->id(), \PDO::PARAM_INT);
    $requete->bindValue(':firstName', $user->login());
    $requete->bindValue(':email',     $user->email());
    $requete->bindValue(':lastName',  $user->lastName());
    $requete->bindValue(':message',   $user->message());

    $requete->execute();
  }
}
