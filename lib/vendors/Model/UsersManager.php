<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Users;

abstract class UsersManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un users.
   * @param $users Le users à ajouter
   * @return void
   */
  abstract protected function add(Users $users);

  /**
   * Méthode permettant de supprimer un users.
   * @param $id L'identifiant du users à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir un users.
   * @param $login L'identifiant du users
   * @return User
   */
  abstract public function getUsers($login);

  /**
   * Méthode permettant de modifier un users.
   * @param $users Users Le users à modifier
   * @return Void
   */
  abstract public function update(Users $users);

  /**
   * Méthode permettant d'enregistrer un users.
   * @param $users Users le users à enregistrer
   * @see self::add()
   * @see self::modify()
   * @return void
   */
  public function save(Users $users)
  {
    if ($users->isValid())
    {
      $users->isNew() ? $this->add($users) : $this->update($users);
    }
    else
    {
      throw new \RuntimeException('Le users doit être valide pour être enregistré');
    }
  }
}
