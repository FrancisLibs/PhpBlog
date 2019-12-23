<?php
namespace Entity;

use \OCFram\Entity;

class User extends Entity
{
  protected $id,
            $name,
            $email,
            $password,
            $create_date,
            $status,
            $level;

  const USER_INVALIDE = 1;
  const NAME_INVALIDE = 2;
  const EMAIL_INVALIDE = 3;
  const PASSWORD_INVALIDE = 4;

  public function isValid()
  {
    return !(empty($this->email) || empty($this->name) || empty($this->password));
  }


  // SETTERS //

  public function setName($name)
  {
    if (!is_string($name) || empty($name))
    {
      $this->erreurs[] = self::NAME_INVALIDE;
    }

    $this->auteur = $author;
  }

  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
    }
    else{
      if (!preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $email ) )
      {
        $this->erreurs[] = self::EMAIL_INVALIDE;
      }
    }

    $this->email = $email;
  }

  public function setPassword($password)
  {
    if (!is_string($password) || empty($password))
    {
      $this->erreurs[] = self::PASSWORD_INVALIDE;
    }

    $this->password = $password;
  }

  public function setCreate_Date(\DateTime $create_Date)
  {
    $this->create_date = $create_date;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function setLevel($level)
  {
    $this->level = $level;
  }

  // GETTERS //

  public function id()
  {
    return $this->id;
  }

  public function name()
  {
    return $this->name;
  }

  public function email()
  {
    return $this->email;
  }

  public function password()
  {
    return $this->password;
  }

  public function create_date()
  {
    return $this->create_date;
  }

  public function status()
  {
    return $this->status;
  }

  public function level()
  {
    return $this->level;
  }
}
