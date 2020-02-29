<?php
namespace Entity;

use \OCFram\Entity;

class Users extends Entity
{
  protected $id,
            $login,
            $email,
            $password,
            $verifyPassword,
            $create_date,
            $status,
            $role_id,
            $role,
            $vkey,
            $formToken;

  const LOGIN_INVALIDE = 1;
  const EMAIL_INVALIDE = 2;
  const PASSWORD_INVALIDE = 3;
  const VERIFY_PASSWORD_INVALIDE = 4;

  /* ---- Functions ---*/

  public function isValid()
  {
    return !(empty($this->login) || empty($this->email) || empty($this->password));
  }

  public function registrationFormIsValid()
  {
   return (!empty($this->login()) && !empty($this->email()) && !empty($this->password()) && !empty($this->verifyPassword()));
  }

  public function passwordHash()
  {
    return password_hash($this->password, PASSWORD_DEFAULT);
  }

  public function comparePasswords($usersBddPassword)
  {
    return password_verify($this->password(), $usersBddPassword);
  }

  // SETTERS //

  public function setLogin($login)
  {
    if (!is_string($login) || empty($login))
    {
      $this->erreurs[] = self::LOGIN_INVALIDE;
    }
    $this->login = $login;
  }

  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
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

  public function setVerifyPassword($verifyPassword)
  {
    if (!is_string($verifyPassword) || empty($verifyPassword))
    {
      $this->erreurs[] = self::VERIFY_PASSWORD_INVALIDE;
    }

    $this->verifyPassword = $verifyPassword;
  }

  public function setCreate_date(\DateTime $create_date)
  {
    $this->create_date = $create_date;
  }

  public function setStatus($status)
  {
    $this->status = $status;
  }

  public function setRole_id($role_id)
  {
    $this->role_id = $role_id;
  }

  public function setRole($role)
  {
    $this->role = $role;
  }
  
  public function setVkey($vkey)
  {
    $this->vkey = $vkey;
  }
  
  public function setFormToken($formToken)
  {
    $this->formToken = $formToken;
  }

  // GETTERS //

  public function id()
  {
    return $this->id;
  }

  public function login()
  {
    return $this->login;
  }

  public function email()
  {
    return $this->email;
  }

  public function password()
  {
    return $this->password;
  }

  public function verifyPassword()
  {
    return $this->verifyPassword;
  }

  public function create_date()
  {
    return $this->create_date;
  }

  public function status()
  {
    return $this->status;
  }

  public function role_id()
  {
    return $this->role_id;
  }

  public function role()
  {
    return $this->role;
  }
  
  public function vkey()
  {
    return $this->vkey;
  }

  public function formToken()
  {
    return $this->formToken;
  }
  
}
