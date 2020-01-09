<?php
namespace Model;

use \OCFram\Manager;
use \Entity\User;

abstract class UserManager extends Manager
{
  /**
   * Méthode permettant d'ajouter un user.
   * @param $user Le user à ajouter
   * @return void
   */
  abstract protected function add(User $user);

  /**
   * Méthode permettant de supprimer un user.
   * @param $id L'identifiant du user à supprimer
   * @return void
   */
  abstract public function delete($id);

  /**
   * Méthode permettant d'obtenir un user.
   * @param $id L'identifiant du user
   * @return User
   */
  abstract public function get($id);

  /**
   * Méthode permettant de modifier un user.
   * @param $user User Le user à modifier
   * @return Void
   */
  abstract public function update(User $user);
}
