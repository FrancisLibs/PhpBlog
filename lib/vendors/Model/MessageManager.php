<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Message;

abstract class MessageManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un message.
   * @param $message Le message à ajouter
   * @return void
   */
  abstract protected function add(Message $message);

  /**
   * Méthode permettant d'enregistrer un message.
   * @param $message Le message à enregistrer
   * @return void
   */
  public function save(Message $message)
  {
    if ($message->isValid())
    {
      $message->isNew() ? $this->add($message) : $this->update($message);
    }
    else
    {
      throw new \RuntimeException('Le message doit être validé pour être enregistré');
    }
  }
}
