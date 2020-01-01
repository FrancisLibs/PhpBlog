<?php
namespace Entity;

use \OCFram\Entity;

class Message extends Entity
{
  protected $id,
            $lastName,
            $firstName,
            $email,
            $message,
            $edition_date;

  const USER_INVALIDE = 1;
  const NOM_INVALIDE = 2;
  const PRENOM_INVALIDE = 3;
  const EMAIL_INVALIDE = 4;
  const MESSAGE_INVALIDE = 5;

  public function isValid()
  {
    return !empty($this->lastName) || (empty($this->firstName) || empty($this->email) || empty($this->message));
  }


  // SETTERS //

  public function setLastName($lastName)
  {
    if (!is_string($lastName) || empty($lastName))
    {
      $this->erreurs[] = self::NOM_INVALIDE;
    }

    $this->lastName = $lastName;
  }

   public function setFirstName($firstName)
  {
    if (!is_string($firstName) || empty($firstName))
    {
      $this->erreurs[] = self::PRENOM_INVALIDE;
    }

    $this->firstName = $firstName;
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

  public function lastName()
  {
    return $this->lastName;
  }

  public function firstName()
  {
    return $this->firstName;
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
