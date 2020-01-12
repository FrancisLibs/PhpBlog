<?php
namespace Model;

use \Entity\User;

class UserManagerPDO extends UserManager
{
  protected function add(User $user)
  {
    $requete = $this->dao->prepare('INSERT INTO users SET login = :login, email = :email, password = :password, create_date = NOW(), status = :status, level = :level');

    $requete->bindValue(':login',     $user->login());
    $requete->bindValue(':email',     $user->emailr());
    $requete->bindValue(':password',  $user->password());
    $requete->bindValue(':satus',     $user->status());
    $requete->bindValue(':level',     $user->level());

    $requete->execute();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM users WHERE id = '.(int) $id);
  }

  public function getUser($login)
  {
    $requete = $this->dao->prepare('SELECT id, login, email, password, create_date, status, level FROM users WHERE login = :login');
    $requete->bindValue(':login', $login, \PDO::PARAM_STR);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\User');

    if ($user = $requete->fetch())
    {
      return $user;
    }

    return null;
  }

  public function update(User $user)
  {
    $requete = $this->dao->prepare('UPDATE users SET login = :login, email = :email, password = :password, create_date = NOW(), status = :status, level = :level WHERE id = :id');

    $requete->bindValue(':login',     $user->login());
    $requete->bindValue(':email',     $user->email());
    $requete->bindValue(':password',  $user->password());
    $requete->bindValue(':id',        $user->id(), \PDO::PARAM_INT);
    $requete->bindValue(':status',    $user->status());
    $requete->bindValue(':level',     $user->level());

    $requete->execute();
  }
}
