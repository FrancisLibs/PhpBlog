<?php
namespace Entity;

use \OCFram\Entity;

class Message extends Entity
{
  protected $id,
            $firstName,
            $lastName,
            $email,
            $message,
            $formToken;

  const MESSAGE_INVALIDE = 1;
  const FIRSTNAME_INVALIDE = 2;
  const LASTNAME_INVALIDE = 3;
  const EMAIL_INVALIDE = 4;

  public function isValid()
  {
    return !empty($this->message);
  }

   // SETTERS //

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setFirstName($firstName)
  {
    if (!is_string($firstName) || empty($firstName))
    {
      $this->erreurs[] = self::FIRSTNAME_INVALIDE;
    }

    $this->firstName = $firstName;
  }

  public function setLastName($lastName)
  {
    if (!is_string($lastName) || empty($lastName))
    {
      $this->erreurs[] = self::LASTNAME_INVALIDE;
    }

    $this->lastName = $lastName;
  }

  public function setEmail($email)
  {
    if (!is_string($email) || empty($email))
    {
      $this->erreurs[] = self::EMAIL_INVALIDE;
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

  public function setEdition_date(\DateTime $edition_date)
  {
    $this->edition_date = $edition_date;
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

  public function firstName()
  {
    return $this->firstName;
  }

  public function lastName()
  {
    return $this->lastName;
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

  public function formToken()
  {
    return $this->formToken;
  }
}
