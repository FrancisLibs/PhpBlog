<?php
namespace Entity;

use \OCFram\Entity;

class Contact extends Entity
{
  protected $id,
            $login,
            $email,
            $message,
            $edition_date;

  const USER_INVALIDE = 1;
  const LOGIN_INVALIDE = 2;
  const EMAIL_INVALIDE = 3;
  const MESSAGE_INVALIDE = 4;

  public function isValid()
  {
    return !empty($this->login) || (empty($this->email) || empty($this->message));
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
    else{
      if (!preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $email ) )
      {
        $this->erreurs[] = self::EMAIL_INVALIDE;
      }
    }

    $this->email = $email;
  }

  public function setMessage($message)
  {
    if (!is_string($message) || empty($message))
    {
      $this->erreurs[] = self::MESSAGE_INVALIDE;
    }

    $this->message = $message;
  }

  public function setEdition_Date(\DateTime $edition_Date)
  {
    $this->edition_date = $edition_date;
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

  public function message()
  {
    return $this->message;
  }

  public function edition_date()
  {
    return $this->edition_date;
  }
}
