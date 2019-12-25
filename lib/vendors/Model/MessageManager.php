<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Message;

abstract class MessageManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un message.
   * @param $message Message Le message à ajouter
   * @return void
   */
  abstract protected function add(Message $message);

  /**
   * Méthode permettant de supprimer un message.
   * @param $id int L'identifiant du message à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode retournant une liste de messages demandés.
   * @return array La liste des messages. Chaque entrée est une instance de Message.
   */
  abstract public function getList;

  /**
   * Méthode retournant un message précis.
   * @param $id int L'identifiant du message à récupérer
   * @return Message Le message demandé
   */
  abstract public function getUnique($id);
}
