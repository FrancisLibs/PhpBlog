<?php
namespace Model;

use \Entity\Users;

class UsersManagerPDO extends UsersManager
{
  public function add(Users $users)
  {
    $requete = $this->dao->prepare('INSERT INTO users SET login = :login, email = :email, password = :password, create_date = NOW(), status = :status, role_id = :role_id, vkey = :vkey');

    $requete->bindValue(':login',     $users->login());
    $requete->bindValue(':email',     $users->email());
    $requete->bindValue(':password',  $users->password());
    $requete->bindValue(':status',    $users->status());
    $requete->bindValue(':role_id',   $users->role_id());
    $requete->bindValue(':vkey',      $users->vkey());

    $requete->execute();
  }

  public function delete($id)
  {
    $this->dao->exec('DELETE FROM users WHERE id = '.(int) $id);
  }

  public function getUsers($login)
  {
    $requete = $this->dao->prepare('SELECT id, login, email, password, create_date, status, role_id AS role, vkey FROM users WHERE login = :login');
    $requete->bindValue(':login', $login, \PDO::PARAM_STR);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');
 
    if ($users = $requete->fetch())
    {
      return $users;
    }
    return null;
  }

  public function getUsersId($id)
  {
    $requete = $this->dao->prepare('SELECT u.id, login, email, password, create_date, status, u.role_id, r.role, vkey '
            . 'FROM users u '
            . 'INNER JOIN roles r '
            . 'ON r.id = u.role_id '
            . 'WHERE u.id = :id ');
    $requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $requete->execute();

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');

    if ($users = $requete->fetch())
    {
      return $users;
    }

    return null;
  }

  public function update(Users $users)
  {
    $requete = $this->dao->prepare('UPDATE users SET login = :login, email = :email, password = :password, create_date = NOW(), status = :status, role_id = :role_id WHERE id = :id');

    $requete->bindValue(':login',     $users->login());
    $requete->bindValue(':email',     $users->email());
    $requete->bindValue(':password',  $users->password());
    $requete->bindValue(':id',        $users->id(), \PDO::PARAM_INT);
    $requete->bindValue(':status',    $users->status());
    $requete->bindValue(':role_id',   $users->role_id());

    $requete->execute();
  }

  public function countUsers($login)
  {
    return $this->dao->query('SELECT COUNT(*) FROM users WHERE login = '. '"'.$login.'"')->fetchColumn();
  }

  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM users')->fetchColumn();
  }

  public function getList($data)
  {
    $sql = 'SELECT u.id, login, email, password, create_date, status, u.role_id, r.role '
            . 'FROM users u '
            . 'INNER JOIN roles r '
            . 'ON u.role_id = r.id ';
           
    if($data == 'users')// Que les membres , pas les admin ou superAdmin
    {
        $sql .= 'WHERE u.role_id <= 1';
    }
    elseif($data = 'admin') // Que les "admin", pas les membres ou les superAdmin
    {
        $sql .= 'WHERE u.role_id = 2';
    }
    
    $sql .=  ' ORDER BY u.id ASC';
    
    $requete = $this->dao->query($sql);

    $requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Users');

    $usersList = $requete->fetchAll();


    foreach ($usersList as $users)
    {
      $users->setCreate_date(new \DateTime($users->create_date()));
    }

    $requete->closeCursor();

    return $usersList;
  }
}
